<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property integer $id
 * @property integer $id_users
 * @property string $libelle
 * @property string $description
 * @property string $creation_date
 * @property integer $status
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_users', 'libelle'], 'required'],
            [['id_users', 'status'], 'integer'],
            [['description'], 'string'],
            [['creation_date'], 'safe'],
            [['libelle'], 'string', 'max' => 200],
            [['id_users'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['id_users' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_users' => 'Id Users',
            'libelle' => 'Libelle',
            'description' => 'Description',
            'creation_date' => 'Creation Date',
            'status' => 'Status',
        ];
    }
}
