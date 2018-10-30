<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "ussdtransation".
 *
 * @property integer $id
 * @property string $idtransaction
 * @property string $username
 * @property integer $iduser
 * @property string $menu
 * @property string $datecreation
 * @property integer $sub_menu
 * @property integer $page_menu
 * @property integer $etat_transaction
 * @property string $others
 * @property string $message
 * @property string $message_send
 * @property string $reference
 */
class Ussdtransation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ussdtransation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'menu', 'datecreation', 'sub_menu', 'page_menu', 'etat_transaction', 'reference'], 'required'],
            [['iduser', 'sub_menu', 'page_menu', 'etat_transaction'], 'integer'],
            [['datecreation'], 'safe'],
            [['others', 'message', 'message_send'], 'string'],
            [['idtransaction', 'username', 'menu'], 'string', 'max' => 50],
            [['reference'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idtransaction' => 'Idtransaction',
            'username' => 'Username',
            'iduser' => 'Iduser',
            'menu' => 'Menu',
            'datecreation' => 'Datecreation',
            'sub_menu' => 'Sub Menu',
            'page_menu' => 'Page Menu',
            'etat_transaction' => 'Etat Transaction',
            'others' => 'Others',
            'message' => 'Message',
            'message_send' => 'Message Send',
            'reference' => 'Reference',
        ];
    }
}
