<?php

namespace frontend\modules\editeur\models;

use Yii;

/**
 * This is the model class for table "validite".
 *
 * @property integer $id
 * @property string $designation
 * @property integer $etat
 * @property integer $created_by
 * @property string $date_create
 * @property integer $updated_by
 * @property string $date_update
 * @property string $mot_cle
 *
 * @property Ticket[] $tickets
 * @property User $createdBy
 * @property User $updatedBy
 */
class Validite extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 4;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'validite';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['designation', 'etat', 'created_by', 'date_create','mot_cle'], 'required'],
            [['etat', 'created_by', 'updated_by'], 'integer'],
            [['date_create', 'date_update'], 'safe'],
            [['designation'], 'string', 'max' => 255],
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
            'designation' => 'Designation',
            'mot_cle' => 'mot_cle',
            'etat' => 'Etat',
            'created_by' => 'Created By',
            'date_create' => 'Date Create',
            'updated_by' => 'Updated By',
            'date_update' => 'Date Update',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['validiteId' => 'id'])->inverseOf('validite');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by'])->inverseOf('validites');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by'])->inverseOf('validites0');
    }
}
