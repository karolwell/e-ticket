<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "factures".
 *
 * @property integer $id
 * @property string $numero_client
 * @property integer $facturierId
 * @property string $mois_facture
 * @property string $response
 * @property string $code
 * @property string $date
 * @property integer $etat
 *
 * @property User $facturier
 */
class Factures extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'factures';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numero_client', 'facturierId', 'mois_facture', 'response', 'code', 'date', 'etat'], 'required'],
            [['facturierId', 'etat'], 'integer'],
            [['date'], 'safe'],
            [['numero_client', 'mois_facture', 'response', 'code'], 'string', 'max' => 255],
            [['facturierId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['facturierId' => 'id']],
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
            'facturierId' => 'Facturier ID',
            'mois_facture' => 'Mois Facture',
            'response' => 'Response',
            'code' => 'Code',
            'date' => 'Date',
            'etat' => 'Etat',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturier()
    {
        return $this->hasOne(User::className(), ['id' => 'facturierId']);
    }
}
