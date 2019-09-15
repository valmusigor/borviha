<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "coord".
 *
 * @property int $id
 * @property string $point
 * @property int $floor
 * @property string $number_office
 */
class Coord extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'coord';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['point', 'floor'], 'required'],
            [['floor'], 'integer'],
            [['point'], 'string', 'max' => 255],
            [['number_office'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'point' => 'Координаты',
            'floor' => 'Этаж',
            'number_office' => 'Номер офиса',
        ];
    }
}
