<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "config_facturier".
 *
 * @property integer $id
 * @property integer $userId
 * @property string $url_api
 * @property string $ftp_ip
 * @property string $ftp_username
 * @property string $ftp_password
 * @property integer $etat
 *
 * @property User $user
 */
class ConfigFacturier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'config_facturier';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'etat'], 'required'],
            [['userId', 'etat'], 'integer'],
            [['url_api', 'ftp_ip', 'ftp_username', 'ftp_password'], 'string', 'max' => 255],
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
            'url_api' => 'Url Api',
            'ftp_ip' => 'Ftp Ip',
            'ftp_username' => 'Ftp Username',
            'ftp_password' => 'Ftp Password',
            'etat' => 'Etat',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }
}
