<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "tmoney".
 *
 * @property integer $id
 * @property string $numero_payeur
 * @property string $nom
 * @property string $prenom
 * @property string $solde
 * @property string $langue
 * @property integer $etat
 */
class Tmoney extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tmoney';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numero_payeur', 'nom', 'prenom', 'solde', 'langue', 'etat'], 'required'],
            [['etat'], 'integer'],
            [['numero_payeur', 'nom', 'prenom'], 'string', 'max' => 255],
            [['solde', 'langue'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'numero_payeur' => 'Numero Payeur',
            'nom' => 'Nom',
            'prenom' => 'Prenom',
            'solde' => 'Solde',
            'langue' => 'Langue',
            'etat' => 'Etat',
        ];
    }
}
