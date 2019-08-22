<?php

namespace backend\controllers;

use Yii;
use backend\models\Contract;
use yii\data\ActiveDataProvider;
use backend\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContractController implements the CRUD actions for Contract model.
 */
class ContractController extends BaseController
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
     * Lists all Contract models.
     * @return mixed
     */
//    public function actionIndex()
//    {
//        $dataProvider = new ActiveDataProvider([
//            'query' => Contract::find(),
//        ]);
//
//        return $this->render('index', [
//            'dataProvider' => $dataProvider,
//        ]);
//    }
//
//    /**
//     * Displays a single Contract model.
//     * @param integer $id
//     * @return mixed
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }

    /**
     * Creates a new Contract model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($agent_id)
    {
        $model = new Contract();

        if ($model->load(Yii::$app->request->post()) ) {
            $model->agent_id=$agent_id;
            if($model->save())
            {
            Yii::$app->session->setFlash('success', 'Договор успешно добавлен');
            return $this->redirect(['/agent/view', 'id' => $agent_id]);
            }
            Yii::$app->session->setFlash('error', 'Ошибка добавления договора');
        }

        return $this->render('update', [
            'model' => $model,'agent_id'=>$agent_id
        ]);
    }
    /**
     * Updates an existing Contract model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id,$agent_id)
    {
        $model = $this->findModel($id,$agent_id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/agent/view', 'id' => $agent_id]);
        }

        return $this->render('update', [
            'model' => $model,'agent_id'=>$agent_id,
        ]);
    }

    /**
     * Deletes an existing Contract model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id,$agent_id)
    {
        
        $this->findModel($id,$agent_id)->delete();

        return $this->redirect(['/agent/view', 'id' => $agent_id]);
    }

    /**
     * Finds the Contract model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Contract the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id,$agent_id)
    {
        if (($model = Contract::findOne(['id'=>$id,'agent_id'=>$agent_id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionUpdateAgent($id){
        if(($contract= Contract::findOne($id)))
                return $this->renderAjax('/agent/_add_contract_form', ['model'=>$contract]); 
                //return $this->renderAjax ('/agent/_form', ['id'=>$id]);
    }
}
