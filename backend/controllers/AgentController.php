<?php

namespace backend\controllers;
use backend\models\Agent;
use backend\models\forms\AddFiz;
use backend\models\forms\AddJur;
use backend\models\AgentSearch;
use backend\models\Contract;
use backend\models\Legals;
use backend\models\Passports;
use yii\data\ActiveDataProvider;
use backend\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
/**
 * AgentController implements the CRUD actions for Agent model.
 */
class AgentController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Agent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AgentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Agent model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
         $dataProvider = new ActiveDataProvider([
            'query' => Contract::find()->where(['agent_id'=>$id]),
        ]);
        $agent=$this->findModel($id);
        if($agent->type= Agent::AGENT_OWNER){
            //для поиска всех арендаторов собственника
             $dataProvider_contract_renter = new ActiveDataProvider([
            'query' => Contract::find()->where(['connection_id'=>$id]),
        ]);   
         return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $agent,
            'dataProvider_contract_renter'=>$dataProvider_contract_renter
        ]);
        }
        else
        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $agent,
        ]);
    }

    /**
     * Creates a new Agent  model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateJur()
    {
        $model = new AddJur();
        if ($model->load(Yii::$app->request->post()) && ($id=$model->save())){
            Yii::$app->session->setFlash('success', 'Успешно добавлен');
            return $this->redirect(['view', 'id' => $id]);
        }
        return $this->render('create', [
            'model' => $model
        ]);
    }
    public function actionCreateFiz()
    {
        $model = new AddFiz(); 
        if ($model->load(Yii::$app->request->post()) && ($id=$model->save())) {
            Yii::$app->session->setFlash('success', 'Успешно добавлен');
            return $this->redirect(['view', 'id' => $id]);
        }
        return $this->render('create', [
            'model' => $model
        ]);
    }
    
    
    /**
     * Updates an existing Agent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if(Yii::$app->request->isPost)
        {
            foreach (Yii::$app->request->post('Contract') as $id=>$value)
            {
                if(($contract=Contract::findOne($id)) && $contract->agent_id===$model->id){
                    $contract->attributes=$value;
                    if(!$contract->save()){
                        return $this->render('update', [
                        'model' => $model,
                        ]);
                    }
                }
                else return $this->render('update', [
                        'model' => $model,
                        ]);
            }
           if($model->person_org===1)
           {
               $model->legals->attributes=Yii::$app->request->post('Legals'); 
               if(!$model->legals->save())
               {
                   return $this->render('update', [
                        'model' => $model,
                        ]);
               }
           }
           else if($model->person_org===2){
               $model->passports->attributes=Yii::$app->request->post("Passports"); 
               if(!$model->passports->save())
               {
                   return $this->render('update', [
                        'model' => $model,
                        ]);
               }
           }
           $model->attributes=Yii::$app->request->post('Agent');
           if($model->save()){
              Yii::$app->session->setFlash('success', 'Успешно обновлены');
              return $this->redirect(['view', 'id' => $model->id]);     
           }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Agent model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(!($agent=$this->findModel($id))){
            Yii::$app->session->setFlash('error', 'Ошибка удаления');
            return $this->redirect(['index']);  
        }
        if(($contracts=Contract::find()->where(['agent_id'=>$id])->all()))
        {
            foreach ($contracts as $contract) $contract->delete ();
        }
        if($agent->person_org===1  && $legals= Legals::findOne(['agent_id'=>$id]))
        {
           $legals->delete();
        }
        else if($agent->person_org===2  && $passports= Passports::findOne(['agent_id'=>$id]))
        {
            $passports->delete();
        }
        $agent->delete();
        Yii::$app->session->setFlash('success', 'Успешно удалено');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Agent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Agent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Agent::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionLoad(){
        return $this->render('create', ['model'=>(Yii::$app->request->get('person_org')==2? new AddFiz(): new AddJur())]);
    }
}
