<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "top_evenement".
 *
 * @property integer $id
 * @property integer $activiteId
 * @property string $date_create
 * @property integer $created_by
 * @property string $date_update
 * @property integer $updated_by
 * @property string $date_fin
 * @property integer $etat
 * @property string $message
 *
 * @property Activite $activite
 * @property User $createdBy
 * @property User $updatedBy
 */
class TopEvenement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'top_evenement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activiteId', 'date_create', 'created_by', 'date_fin', 'etat', 'message'], 'required'],
            [['activiteId', 'created_by', 'updated_by', 'etat'], 'integer'],
            [['date_create', 'date_update', 'date_fin'], 'safe'],
            [['message'], 'string', 'max' => 255],
            [['activiteId'], 'exist', 'skipOnError' => true, 'targetClass' => Activite::className(), 'targetAttribute' => ['activiteId' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'activiteId' => 'Activite ID',
            'date_create' => 'Date Create',
            'created_by' => 'Created By',
            'date_update' => 'Date Update',
            'updated_by' => 'Updated By',
            'date_fin' => 'Date Fin',
            'etat' => 'Etat',
            'message' => 'Message',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivite()
    {
        return $this->hasOne(Activite::className(), ['id' => 'activiteId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
}
