<?php

namespace api\modules\v1\models;

use Yii;
use \yii\db\ActiveRecord;
/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 *
 * @property Tasks[] $tasks
 */
class Users extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['id_users' => 'id'])->inverseOf('idUsers');
    }
}
