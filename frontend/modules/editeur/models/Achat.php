<?php

namespace frontend\modules\editeur\models;

use Yii;

/**
 * This is the model class for table "achat".
 *
 * @property integer $id
 * @property string $numero_client
 * @property string $dateAchat
 * @property string $montant
 * @property integer $etat
 * @property string $code_facture
 *
 * @property AchatDetails[] $achatDetails
 * @property TicketGratuit[] $ticketGratuits
 */
class Achat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'achat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numero_client', 'dateAchat', 'montant', 'etat', 'code_facture'], 'required'],
            [['dateAchat'], 'safe'],
            [['etat'], 'integer'],
            [['numero_client'], 'string', 'max' => 20],
            [['montant', 'code_facture'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'numero_client' => 'Numero Client',
            'dateAchat' => 'Date Achat',
            'montant' => 'Montant',
            'etat' => 'Etat',
            'code_facture' => 'Code Facture',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAchatDetails()
    {
        return $this->hasMany(AchatDetails::className(), ['achatId' => 'id'])->inverseOf('achat');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicketGratuits()
    {
        return $this->hasMany(TicketGratuit::className(), ['code_impression' => 'id'])->inverseOf('codeImpression');
    }
}
