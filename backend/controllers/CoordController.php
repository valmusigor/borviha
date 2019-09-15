<?php

namespace backend\controllers;

use Yii;
use backend\models\Coord;
use backend\models\CoordSearch;
use yii\web\Controller;
use backend\models\forms\AddLoc;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Locagent;

/**
 * CoordController implements the CRUD actions for Coord model.
 */
class CoordController extends Controller
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
     * Lists all Coord models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'models'=>$this->findModelsByNumberFloor(11),
        ]);
    }

    /**
     * Displays a single Coord model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Coord model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Coord();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Coord model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Coord model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Coord model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Coord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Coord::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
     protected function findModelsByNumberFloor($floor)
    {
        if (($models = Coord::find()->where(['floor'=>$floor])->all()) !== null) {
            return $models;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
     public function actionLoad($floor){
        return $this->render('create', ['model'=>(Yii::$app->request->get('person_org')==2? new AddFiz(): new AddJur())]);
    }
     public function actionEdit($id){
        $model=$this->findModel($id);
        $locagent=$this->createLocagent($model);
        if($locagent->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post()) && $model->save() && $locagent->save($model) )
        {
            Yii::$app->session->setFlash('success', 'Агент добавлен');
        }
        return $this->render('index', [
           'models'=>$this->findModelsByNumberFloor($model->floor),
           'edit_model'=>$model,
            'locagent'=> $locagent,
        ]);
    }
    protected function createLocagent($model){
        $locagent=new AddLoc();
        if($model->number_office)
            if(($locagents=Locagent::find()->where(['number_office'=>$model->number_office])->all()))
            {
                $locagent->square=$locagents[0]->square;
                $locagent->number_contract=$locagents[0]->contract->number_contract;
                $locagent->agent_name=$locagents[0]->contract->agent->name;
            } 
            
            return $locagent;
    }
}
