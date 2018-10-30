<?php

namespace frontend\modules\editeur\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $prenoms
 * @property string $contact
 * @property string $email
 * @property integer $type_userId
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $logo
 * @property string $identifiant
 * @property integer $paysId
 *
 * @property Abonnement[] $abonnements
 * @property Activite[] $activites
 * @property Activite[] $activites0
 * @property Activite[] $activites1
 * @property CategorieActivite[] $categorieActivites
 * @property CategorieActivite[] $categorieActivites0
 * @property Compte[] $comptes
 * @property ConfigEditeur[] $configEditeurs
 * @property ConfigFacturier[] $configFacturiers
 * @property Factures[] $factures
 * @property TicketGratuit[] $ticketGratuits
 * @property TopEvenement[] $topEvenements
 * @property TopEvenement[] $topEvenements0
 * @property Transfert[] $transferts
 * @property TypeAbonnement[] $typeAbonnements
 * @property TypeAbonnement[] $typeAbonnements0
 * @property TypeTicket[] $typeTickets
 * @property TypeTicket[] $typeTickets0
 * @property TypeTicket[] $typeTickets1
 * @property TypeUser[] $typeUsers
 * @property TypeUser[] $typeUsers0
 * @property TypeUser $typeUser
 * @property Pays $pays
 * @property Validation[] $validations
 * @property Validite[] $validites
 * @property Validite[] $validites0
 */
class User extends \yii\db\ActiveRecord
{

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const ROLE_USER = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'contact', 'type_userId', 'auth_key', 'password_hash', 'created_at', 'paysId'], 'required'],
            [['type_userId', 'role', 'status', 'created_at', 'updated_at', 'paysId'], 'integer'],
            [['username', 'prenoms', 'contact', 'email', 'password_hash', 'password_reset_token', 'logo'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['identifiant'], 'string', 'max' => 10],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            ['role', 'default', 'value' => self::ROLE_USER],
            ['role', 'in', 'range' => [self::ROLE_USER]],
            [['type_userId'], 'exist', 'skipOnError' => true, 'targetClass' => TypeUser::className(), 'targetAttribute' => ['type_userId' => 'id']],
            [['paysId'], 'exist', 'skipOnError' => true, 'targetClass' => Pays::className(), 'targetAttribute' => ['paysId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'prenoms' => 'Prenoms',
            'contact' => 'Contact',
            'email' => 'Email',
            'type_userId' => 'Type User ID',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'role' => 'Role',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'logo' => 'Logo',
            'identifiant' => 'Identifiant',
            'paysId' => 'Pays ID',
        ];
    }

    /****** common**/



    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }



    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomKey();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomKey() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /****** common**/



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAbonnements()
    {
        return $this->hasMany(Abonnement::className(), ['editeurId' => 'id'])->inverseOf('editeur');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivites()
    {
        return $this->hasMany(Activite::className(), ['editeurId' => 'id'])->inverseOf('editeur');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivites0()
    {
        return $this->hasMany(Activite::className(), ['created_by' => 'id'])->inverseOf('createdBy');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivites1()
    {
        return $this->hasMany(Activite::className(), ['updated_by' => 'id'])->inverseOf('updatedBy');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategorieActivites()
    {
        return $this->hasMany(CategorieActivite::className(), ['created_by' => 'id'])->inverseOf('createdBy');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategorieActivites0()
    {
        return $this->hasMany(CategorieActivite::className(), ['updated_by' => 'id'])->inverseOf('updatedBy');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComptes()
    {
        return $this->hasMany(Compte::className(), ['userId' => 'id'])->inverseOf('user');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfigEditeurs()
    {
        return $this->hasMany(ConfigEditeur::className(), ['userId' => 'id'])->inverseOf('user');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfigFacturiers()
    {
        return $this->hasMany(ConfigFacturier::className(), ['userId' => 'id'])->inverseOf('user');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFactures()
    {
        return $this->hasMany(Factures::className(), ['facturierId' => 'id'])->inverseOf('facturier');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicketGratuits()
    {
        return $this->hasMany(TicketGratuit::className(), ['numero_client' => 'id'])->inverseOf('numeroClient');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopEvenements()
    {
        return $this->hasMany(TopEvenement::className(), ['created_by' => 'id'])->inverseOf('createdBy');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopEvenements0()
    {
        return $this->hasMany(TopEvenement::className(), ['updated_by' => 'id'])->inverseOf('updatedBy');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransferts()
    {
        return $this->hasMany(Transfert::className(), ['senderId' => 'id'])->inverseOf('sender');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeAbonnements()
    {
        return $this->hasMany(TypeAbonnement::className(), ['created_by' => 'id'])->inverseOf('createdBy');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeAbonnements0()
    {
        return $this->hasMany(TypeAbonnement::className(), ['updated_by' => 'id'])->inverseOf('updatedBy');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeTickets()
    {
        return $this->hasMany(TypeTicket::className(), ['created_by' => 'id'])->inverseOf('createdBy');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeTickets0()
    {
        return $this->hasMany(TypeTicket::className(), ['updated_by' => 'id'])->inverseOf('updatedBy');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeTickets1()
    {
        return $this->hasMany(TypeTicket::className(), ['editeurId' => 'id'])->inverseOf('editeur');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeUsers()
    {
        return $this->hasMany(TypeUser::className(), ['created_by' => 'id'])->inverseOf('createdBy');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeUsers0()
    {
        return $this->hasMany(TypeUser::className(), ['updated_by' => 'id'])->inverseOf('updatedBy');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeUser()
    {
        return $this->hasOne(TypeUser::className(), ['id' => 'type_userId'])->inverseOf('users');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPays()
    {
        return $this->hasOne(Pays::className(), ['id' => 'paysId'])->inverseOf('users');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValidations()
    {
        return $this->hasMany(Validation::className(), ['validated_by' => 'id'])->inverseOf('validatedBy');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValidites()
    {
        return $this->hasMany(Validite::className(), ['created_by' => 'id'])->inverseOf('createdBy');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValidites0()
    {
        return $this->hasMany(Validite::className(), ['updated_by' => 'id'])->inverseOf('updatedBy');
    }
}
