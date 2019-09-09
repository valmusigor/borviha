<?php

namespace backend\controllers;
use backend\models\Infiles;
use backend\controllers\BaseController;
use Yii;
use backend\models\Invoices;
use backend\models\InvoicesSearch;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Accrual;

/**
 * InvoiceController implements the CRUD actions for Invoices model.
 */
class InvoiceController extends BaseController
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
     * Lists all Invoices models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InvoicesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $exist_result=null;
        $model=new Infiles();
        if(Yii::$app->request->isPost){
            if($model->upload((UploadedFile::getInstance($model, 'upload_name')))){
                if(($exist_result=$this->uploadExel($model)) && is_array($exist_result) && isset($exist_result['exist']))
                {
//                    print_r($exist_result);
//                    exit();
                }
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
     * Displays a single Invoices model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
        $this->redirect(['accrual/index','invoice_id'=>$id]);
    }

    /**
     * Creates a new Invoices model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Invoices();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Invoices model.
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
     * Deletes an existing Invoices model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model=$this->findModel($id);
        $number_invoice=$model->number_invoice;
        foreach ($model->accruals as $accrual)
            if(!$accrual->delete())
            {
                Yii::$app->session->setFlash('error', 'Ошибка удаления начисления'.Accrual::NAMES_ACCRUAL[$accrual->name_accrual].'для счета№'. $number_invoice);
                return $this->redirect(['index']);
            }
        if(!$model->delete())
        {
        Yii::$app->session->setFlash('error', 'Ошибка удаления счета'.$number_invoice);
        return $this->redirect(['index']);
        }
        Yii::$app->session->setFlash('success', 'Cчет №'.$number_invoice.' успешно удалены');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Invoices model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Invoices the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoices::findOne($id)) !== null) {
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
                    if(($temp_model= Invoices::checkExistAccrual($data[$i]))){
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
                         return ['exist'=>$i,'number_invoice'=>$data[$i][Accrual::KEY_MAPPING['number_invoice']],'date_invoice'=>$data[$i][Accrual::KEY_MAPPING['date_invoice']],'status'=>false];
                        }
                    }
                    else {
                    
                    if(!($invoice=Invoices::checkExistInvoice($data[$i])))
                    {
                        $invoice=new Invoices();
                        $invoice->date_invoice= $data[$i][Accrual::KEY_MAPPING['date_invoice']];
                        $invoice->number_invoice=$data[$i][Accrual::KEY_MAPPING['number_invoice']];
                        $invoice->contract_id= \backend\models\Contract::getContractId($data[$i][Accrual::KEY_MAPPING['agent']],$data[$i][Accrual::KEY_MAPPING['contract']]);
                        if(!$invoice->save()){
                             Yii::$app->session->setFlash('error', 'Ошибка сохранения данных счета при обработке строки'.$i);
                        }
                    }
                    $accrual=new Accrual();
                    if(!$accrual->saveData($data[$i], $invoice->id)){
                         Yii::$app->session->setFlash('error', 'Ошибка сохранения данных начисления при обработке строки'.$i);
                    }
                }   
               }
                return ['status'=>true];
    }
     public function actionContinueUnloading($choose_action,$line,$id)
    {
        $searchModel = new InvoicesSearch();
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
    public function actionCreatePdf($id){
   // $html = file_get_contents(Yii::getAlias('@backend').'/web/templates/invoice.php');
$this->layout='main_blank';

$mpdf = new \Mpdf\Mpdf([
    // 'mode' => 'utf-8',
    'mode' => 's',
	'margin_left' => 20,
	'margin_right' => 15,
	//'margin_top' => 48,
	'margin_bottom' => 25,
	'margin_header' => 10,
	'margin_footer' => 10
]);
$mpdf->SetProtection(array('print'));
$mpdf->SetTitle("Acme Trading Co. - Invoice");
$mpdf->SetAuthor("Acme Trading Co.");
$mpdf->SetWatermarkText("ТС Борвиха плюс");
$mpdf->showWatermarkText = true;
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->watermarkTextAlpha = 0.1;
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML( $this->render('create-pdf',['model'=>$this->findModel($id)]));
//$mpdf->Output(Yii::getAlias('@backend').'/web/invoices/new.pdf',\Mpdf\Output\Destination::FILE);
//return Yii::getAlias('@backend').'/web/invoices/new.pdf';
return (Yii::$app->controller->action->id==='create-pdf' && Yii::$app->controller->id==='invoice')?$mpdf->Output():$mpdf->Output('', 'S'); 
    }
    public function actionSendEmail($id){
       // $model = $this->findModel($id);
        if($this->mailSender($id))
           Yii::$app->session->setFlash ('success', "EMAIL SENDED"); 
     else  Yii::$app->session->setFlash ('danger', "FAIL SENDED"); 
     return $this->redirect(['index']);
        
    }
    protected function mailSender($id){
       return Yii::$app->mailer->compose()
    ->setFrom('x-ray-moby@mail.ru')
    ->setTo('x-ray-moby@mail.ru')
    ->setSubject('Тема сообщения')
    ->setTextBody('Текст сообщения')
    ->setHtmlBody('<b>текст сообщения в формате HTML</b>')
    ->attachContent($this->actionCreatePdf($id), ['fileName' => 'invoice.pdf', 'contentType' => 'application/pdf'])
    ->send();
    }
    public function actionSend(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//        $choose_invoice= json_decode(\Yii::$app->request->post(),true);
//        foreach ($choose_invoice['choose_invoice'] as $value){
//            $this->mailSender($value);
//        }
        
        return json_encode('all right');
//        $notary = Notary::getNotary($id);
//        if(!$notary) return json_encode (FALSE);
//        if($notary->status===2 || $notary->status===3){
//            if($notary->client_id!==Yii::$app->user->identity->id && $notary->notary_id!==Yii::$app->user->identity->id)
//            return json_encode (false);  
//        }
//        $messages= Messages::getMessagesByNotary($id);
//        foreach ($messages as $message){
//            $result[]=[
//                'text_message'=>$message->text_message,
//                'time_create'=>$message->time_create,
//                'sender'=> \frontend\models\User::getUsernameById($message->sender_id),
//            ];
//        }
//        if($messages){
//            
//            return json_encode($result); 
//        }
//        else json_encode (FALSE);
    }
}
