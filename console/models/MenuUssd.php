<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "menu_ussd".
 *
 * @property integer $id_menu_ussd
 * @property integer $position_menu_ussd
 * @property string $denomination
 * @property string $description
 * @property integer $status
 * @property string $date_create
 */
class MenuUssd extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_ussd';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['position_menu_ussd', 'denomination', 'description', 'date_create'], 'required'],
            [['position_menu_ussd', 'status'], 'integer'],
            [['description'], 'string'],
            [['date_create'], 'safe'],
            [['denomination'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_menu_ussd' => 'Id Menu Ussd',
            'position_menu_ussd' => 'Position Menu Ussd',
            'denomination' => 'Denomination',
            'description' => 'Description',
            'status' => 'Status',
            'date_create' => 'Date Create',
        ];
    }
}
