<?php

namespace frontend\modules\editeur\models;

use Yii;

/**
 * This is the model class for table "compte".
 *
 * @property integer $id
 * @property integer $userId
 * @property integer $niveauId
 * @property integer $solde
 * @property string $numero_compte
 * @property integer $etat
 *
 * @property User $user
 * @property Niveau $niveau
 */
class Compte extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 4;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'compte';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'niveauId', 'numero_compte', 'etat'], 'required'],
            [['userId', 'niveauId', 'solde', 'etat'], 'integer'],
            [['numero_compte'], 'string', 'max' => 225],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
            [['niveauId'], 'exist', 'skipOnError' => true, 'targetClass' => Niveau::className(), 'targetAttribute' => ['niveauId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
            'niveauId' => 'Niveau ID',
            'solde' => 'Solde',
            'numero_compte' => 'Numero Compte',
            'etat' => 'Etat',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId'])->inverseOf('comptes');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNiveau()
    {
        return $this->hasOne(Niveau::className(), ['id' => 'niveauId'])->inverseOf('comptes');
    }
}
