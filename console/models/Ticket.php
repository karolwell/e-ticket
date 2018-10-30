<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "ticket".
 *
 * @property integer $id
 * @property string $designation
 * @property integer $prix
 * @property string $nombre_ticket
 * @property integer $type_ticketId
 * @property integer $activiteId
 * @property string $periode
 * @property integer $validiteId
 * @property integer $duree_validite
 * @property integer $nombre_validation
 *
 * @property AchatDetails[] $achatDetails
 * @property TypeTicket $typeTicket
 * @property Activite $activite
 * @property Validite $validite
 */
class Ticket extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ticket';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prix', 'type_ticketId', 'activiteId'], 'required'],
            [['prix', 'type_ticketId', 'activiteId', 'validiteId', 'duree_validite', 'nombre_validation'], 'integer'],
            [['designation', 'nombre_ticket', 'periode'], 'string', 'max' => 255],
            [['type_ticketId'], 'exist', 'skipOnError' => true, 'targetClass' => TypeTicket::className(), 'targetAttribute' => ['type_ticketId' => 'id']],
            [['activiteId'], 'exist', 'skipOnError' => true, 'targetClass' => Activite::className(), 'targetAttribute' => ['activiteId' => 'id']],
            [['validiteId'], 'exist', 'skipOnError' => true, 'targetClass' => Validite::className(), 'targetAttribute' => ['validiteId' => 'id']],
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
            'prix' => 'Prix',
            'nombre_ticket' => 'Nombre Ticket',
            'type_ticketId' => 'Type Ticket ID',
            'activiteId' => 'Activite ID',
            'periode' => 'Periode',
            'validiteId' => 'Validite ID',
            'duree_validite' => 'Duree Validite',
            'nombre_validation' => 'Nombre Validation',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAchatDetails()
    {
        return $this->hasMany(AchatDetails::className(), ['ticketId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeTicket()
    {
        return $this->hasOne(TypeTicket::className(), ['id' => 'type_ticketId']);
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
    public function getValidite()
    {
        return $this->hasOne(Validite::className(), ['id' => 'validiteId']);
    }
}
