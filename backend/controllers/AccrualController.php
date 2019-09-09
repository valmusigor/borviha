<?php

namespace backend\controllers;
use Yii;
use backend\models\Accrual;
use backend\models\AccrualSearch;
use backend\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AccrualController implements the CRUD actions for Accrual model.
 */
class AccrualController extends BaseController
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
     * Lists all Accrual models.
     * @return mixed
     */
    public function actionIndex($invoice_id)
    {
        if(!\backend\models\Invoices::findOne($invoice_id)){
            Yii::$app->session->setFlash('error', 'Счет не существует');
            return $this->redirect(['invoice/index']);
        }
        $searchModel = new AccrualSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$invoice_id);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'invoice_id'=>$invoice_id,
        ]);
    }

    /**
     * Displays a single Accrual model.
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
     * Creates a new Accrual model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($invoice_id)
    {
        if(!\backend\models\Invoices::findOne($invoice_id)){
             throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model = new Accrual();
        if ($model->load(Yii::$app->request->post())) {
            if(\backend\models\Invoices::findOne($invoice_id))
            {
            $model->invoice_id=$invoice_id;
            if($model->save())
            return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,'invoice_id'=>$invoice_id
        ]);
    }

    /**
     * Updates an existing Accrual model.
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
     * Deletes an existing Accrual model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        
        $model=$this->findModel($id);
        $model->delete();

        return $this->redirect(['index','invoice_id'=>$model->invoice_id]);
    }

    /**
     * Finds the Accrual model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Accrual the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Accrual::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
