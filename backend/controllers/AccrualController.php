<?php

namespace backend\controllers;
use backend\models\Infiles;
use Yii;
use backend\models\Accrual;
use backend\models\AccrualSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * AccrualController implements the CRUD actions for Accrual model.
 */
class AccrualController extends Controller
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
    public function actionIndex()
    {
        $model=new Infiles();
        $searchModel = new AccrualSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(Yii::$app->request->isPost){
            if($model->upload((UploadedFile::getInstance($model, 'upload_name')))){
//               $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xls');
//               $reader->setReadDataOnly(true);
//               $spreadsheet = $reader->load(Yii::getAlias('@backend/web/uploadInvoices/').$model->file_name[0].'/'.$model->file_name);
//               $workSheet = $spreadSheet->getActiveSheet();
//               $cellC1 = $workSheet->getCell('C1');
//               echo "<pre>";
//               print_r($spreadsheet);
//               exit();
                //Yii::$app->session->setFlash('success', 'FILE UPLODED');
                //return $this->redirect( Url::to(['file/index']));
            }
        }    
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$model,
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
    public function actionCreate()
    {
        $model = new Accrual();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
    public function actionUploadExel(){
        $model= Infiles::findOne(5);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xls');
               $reader->setReadDataOnly(true);
               $spreadSheet = $reader->load(Yii::getAlias('@backend/web/uploadInvoices/').$model->file_name[0].'/'.$model->file_name);
               $sheetData = $spreadSheet->getActiveSheet()->toArray(null, true, true, true);
                foreach ($sheetData  as $key => $data){
                    if(!isset($data['A']))
                        continue;
                    $accrual=new Accrual();
                    $accrual->date_accrual=$data[Accrual::KEY_MAPPING['data_accrual']];
                    $accrual->number_invoice=$data[Accrual::KEY_MAPPING['number_invoice']];
                    $accrual->contract_id= \backend\models\Contract::getContractId($data[Accrual::KEY_MAPPING['agent']],$data[Accrual::KEY_MAPPING['contract']]);
                    $accrual->name_accrual=$data[Accrual::KEY_MAPPING['name_accrual']];
                    $accrual->units=$data[Accrual::KEY_MAPPING['units']];
                    $accrual->quantity=$data[Accrual::KEY_MAPPING['quantity']];
                    $accrual->price=$data[Accrual::KEY_MAPPING['price']];
                    $accrual->sum=$data[Accrual::KEY_MAPPING['sum']];
                    $accrual->vat=$data[Accrual::KEY_MAPPING['vat']];
                    $accrual->sum_with_vat=$data[Accrual::KEY_MAPPING['sum_with_vat']];
                    if(!$accrual->save()){
                        break;
                        Yii::$app->session->setFlash('error', 'Ошибка в обработке строки'.$key);
                    }
                }    
    }    
}
