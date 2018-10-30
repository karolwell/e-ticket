<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_confirm;
    public $type_userId;
    public $logo;

    /**
     * @var UploadedFile
    */
    public $imageFile;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['type_userId', 'required'],
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            [['password','password_confirm'], 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }


    public function upload()
    {
        if ($this->validate()) {
            //print_r( $this->imageFile);exit;
            $this->imageFile->saveAs('images/editeurs/'. $this->imageFile->baseName . '.' . $this->imageFile->extension);
            $this->imageFile = null; 
           // $model->save(false);
            return true;
        } else {
            //print_r($this->getErrors());
            return false;
        }
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {

            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->logo = $this->logo;
            $user->type_userId = $this->type_userId;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->save();
            return $user;
        }

        return null;
    }
}
