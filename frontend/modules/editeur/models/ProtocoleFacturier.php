<?php

namespace frontend\modules\editeur\models;

use Yii;

/**
 * This is the model class for table "protocole_facturier".
 *
 * @property integer $id
 * @property integer $userId
 * @property string $url
 * @property string $ftp_ip
 * @property string $ftp_username
 * @property string $ftp_password
 *
 * @property User $user
 */
class ProtocoleFacturier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'protocole_facturier';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId'], 'required'],
            [['userId'], 'integer'],
            [['url', 'ftp_ip', 'ftp_username', 'ftp_password'], 'string', 'max' => 255],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
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
            'url' => 'Url',
            'ftp_ip' => 'Ftp Ip',
            'ftp_username' => 'Ftp Username',
            'ftp_password' => 'Ftp Password',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId'])->inverseOf('protocoleFacturiers');
    }
}
