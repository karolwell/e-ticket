<?php

namespace frontend\modules\editeur\models;

use Yii;

/**
 * This is the model class for table "niveau".
 *
 * @property integer $id
 * @property string $designation
 * @property integer $montant_max
 * @property integer $nbre_activite
 * @property integer $etat
 *
 * @property Compte[] $comptes
 */
class Niveau extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 4;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'niveau';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['designation', 'montant_max', 'nbre_activite', 'etat'], 'required'],
            [['montant_max', 'nbre_activite', 'etat'], 'integer'],
            [['designation'], 'string', 'max' => 225],
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
            'montant_max' => 'Montant Max',
            'nbre_activite' => 'Nbre Activite',
            'etat' => 'Etat',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComptes()
    {
        return $this->hasMany(Compte::className(), ['niveauId' => 'id'])->inverseOf('niveau');
    }
}
