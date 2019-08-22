<?php

namespace backend\models;
use common\models\User;
use Yii;

/**
 * This is the model class for table "infiles".
 *
 * @property int $id
 * @property string $file_name
 * @property string $upload_name
 * @property int $date_uploads
 * @property int $user_id
 *
 * @property User $user
 */
class Infiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'infiles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_uploads', 'user_id'], 'required'],
            [['date_uploads', 'user_id'], 'integer'],
            [['file_name'], 'string', 'max' => 50],
            [['upload_name'], 'string', 'max' =>30],
            [['file_name'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            ['upload_name', 'file', 'extensions' => ['xls'], 'maxSize' => 1024*1024*2]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_name' => 'File Name',
            'upload_name' => 'Upload Name',
            'date_uploads' => 'Date Uploads',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
     public  function upload($file_obj){
           $this->upload_name=$file_obj->baseName.'.'.$file_obj->extension;
           $fileName=md5($file_obj->baseName.rand(1,99).time()).'.'.$file_obj->extension;
           $this->file_name=$fileName;
           $this->date_uploads= time();
           $this->user_id=Yii::$app->user->identity->id;
           if(!file_exists(Yii::getAlias('@backend/web/uploadInvoices/').$fileName[0]))
           mkdir(Yii::getAlias('@backend/web/uploadInvoices/').$fileName[0],0777, true);
           if($file_obj->saveAs(Yii::getAlias('@backend/web/uploadInvoices/').$fileName[0].'/'.$fileName) && $this->save())
           return true;
       return false;
   }
}
