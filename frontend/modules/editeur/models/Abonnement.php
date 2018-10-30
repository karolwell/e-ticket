<?php

namespace frontend\modules\editeur\models;

use Yii;

/**
 * This is the model class for table "abonnement".
 *
 * @property integer $id
 * @property integer $editeurId
 * @property integer $type_abonnementId
 * @property string $date_detut_abonnement
 * @property string $date_fin_abonnement
 * @property integer $etat
 *
 * @property User $editeur
 * @property TypeAbonnement $typeAbonnement
 */
class Abonnement extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 4;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'abonnement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['editeurId', 'type_abonnementId', 'date_detut_abonnement', 'date_fin_abonnement', 'etat'], 'required'],
            [['editeurId', 'type_abonnementId', 'etat'], 'integer'],
            [['date_detut_abonnement', 'date_fin_abonnement'], 'safe'],
            [['editeurId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['editeurId' => 'id']],
            [['type_abonnementId'], 'exist', 'skipOnError' => true, 'targetClass' => TypeAbonnement::className(), 'targetAttribute' => ['type_abonnementId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'editeurId' => 'Editeur ID',
            'type_abonnementId' => 'Type Abonnement ID',
            'date_detut_abonnement' => 'Date Detut Abonnement',
            'date_fin_abonnement' => 'Date Fin Abonnement',
            'etat' => 'Etat',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEditeur()
    {
        return $this->hasOne(User::className(), ['id' => 'editeurId'])->inverseOf('abonnements');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeAbonnement()
    {
        return $this->hasOne(TypeAbonnement::className(), ['id' => 'type_abonnementId'])->inverseOf('abonnements');
    }
}
