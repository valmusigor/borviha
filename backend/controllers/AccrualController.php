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
        $exist_result=null;
        $model=new Infiles();
        $searchModel = new AccrualSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(Yii::$app->request->isPost){
            if($model->upload((UploadedFile::getInstance($model, 'upload_name')))){
                if(($exist_result=$this->uploadExel($model)) && is_array($exist_result) && isset($exist_result['exist']))
                {
//                    print_r($exist_result);
//                    exit();
                }
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
             'exist_result'=>$exist_result,
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
    protected function uploadExel($model,$start_key=1,$choose_action='default'){
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xls');
               $reader->setReadDataOnly(true);
               $spreadSheet = $reader->load(Yii::getAlias('@backend/web/uploadInvoices/').$model->file_name[0].'/'.$model->file_name);
               $data = $spreadSheet->getActiveSheet()->toArray(null, true, true, true);
               for($i=$start_key;$i<count($data);$i++){
               if(!isset($data[$i]['A']))
                        continue;
                    if(($temp_model=Accrual::checkExist($data[$i]))){
                        
                        if($choose_action==='skip' && $i===$start_key)
                            continue;
                        else if($choose_action==='skipall')
                            continue;
                        else if($choose_action==='replace' && $i===$start_key )
                            $accrual=$temp_model;
                        else if($choose_action==='replaceall')
                            $accrual=$temp_model;
                        else{
                         Yii::$app->session->setFlash('error', 'Дублирование строки'.$i);
                         return ['exist'=>$i,'number_invoice'=>$data[$i][Accrual::KEY_MAPPING['number_invoice']],'date_accrual'=>$data[$i][Accrual::KEY_MAPPING['date_accrual']],'status'=>false];
                        }
                    }
                    else $accrual=new Accrual();
                    $accrual->date_accrual= $data[$i][Accrual::KEY_MAPPING['date_accrual']];
                    $accrual->number_invoice=$data[$i][Accrual::KEY_MAPPING['number_invoice']];
                    $accrual->contract_id= \backend\models\Contract::getContractId($data[$i][Accrual::KEY_MAPPING['agent']],$data[$i][Accrual::KEY_MAPPING['contract']]);
                    $accrual->name_accrual= Accrual::convertNameAccrual($data[$i][Accrual::KEY_MAPPING['name_accrual']]);
                    $accrual->units=$data[$i][Accrual::KEY_MAPPING['units']];
                    $accrual->quantity=$data[$i][Accrual::KEY_MAPPING['quantity']];
                    $accrual->price=$data[$i][Accrual::KEY_MAPPING['price']];
                    $accrual->sum=$data[$i][Accrual::KEY_MAPPING['sum']];
                    $accrual->vat=$data[$i][Accrual::KEY_MAPPING['vat']];
                    $accrual->sum_with_vat=$data[$i][Accrual::KEY_MAPPING['sum_with_vat']];
                    if(!$accrual->save()){
                         Yii::$app->session->setFlash('error', 'Ошибка в обработке строки'.$i);
                    }
                }   
                return ['status'=>true];
    }    
    public function actionContinueUnloading($choose_action,$line,$id)
    {
        $searchModel = new AccrualSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if($choose_action==='skip' || $choose_action==='skipall' || $choose_action==='replace' || $choose_action==='replaceall'){
                if(isset($id) && ($model=Infiles::findOne($id)))
                $exist_result=$this->uploadExel($model, $line,$choose_action);
                else $exist_result=false;
        }
        else $exist_result=false;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$model,
             'exist_result'=>$exist_result,
        ]);
    }
}
