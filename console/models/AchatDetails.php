<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "achat_details".
 *
 * @property integer $id
 * @property integer $ticketId
 * @property string $numero_client
 * @property integer $achatId
 * @property string $code
 * @property integer $etat
 *
 * @property Ticket $ticket
 * @property Achat $achat
 * @property Transfert[] $transferts
 * @property Validation[] $validations
 */
class AchatDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'achat_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ticketId', 'numero_client', 'achatId', 'code', 'etat'], 'required'],
            [['ticketId', 'achatId', 'etat'], 'integer'],
            [['numero_client'], 'string', 'max' => 20],
            [['code'], 'string', 'max' => 255],
            [['ticketId'], 'exist', 'skipOnError' => true, 'targetClass' => Ticket::className(), 'targetAttribute' => ['ticketId' => 'id']],
            [['achatId'], 'exist', 'skipOnError' => true, 'targetClass' => Achat::className(), 'targetAttribute' => ['achatId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ticketId' => 'Ticket ID',
            'numero_client' => 'Numero Client',
            'achatId' => 'Achat ID',
            'code' => 'Code',
            'etat' => 'Etat',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicket()
    {
        return $this->hasOne(Ticket::className(), ['id' => 'ticketId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAchat()
    {
        return $this->hasOne(Achat::className(), ['id' => 'achatId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransferts()
    {
        return $this->hasMany(Transfert::className(), ['achat_detailsId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValidations()
    {
        return $this->hasMany(Validation::className(), ['achat_detailsId' => 'id']);
    }
}
