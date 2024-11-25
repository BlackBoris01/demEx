<?php

namespace app\models;
use yii\bootstrap5\Html;
use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $patronymic
 * @property string $login
 * @property string $password
 * @property string $email
 * @property string $phone
 * @property string $profilePhoto
 * @property int $isAdmin
 * @property string $authKey
 * @property string $rules
 *
 * @property Post[] $posts
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
  
    public $profilePhoto;
    public $passwordRep;
    public $rules;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['login', 'email', 'name', 'surname', 'phone', 'password', 'passwordRep'], 'required'],
            [['login', 'email', 'name', 'surname', 'patronymic', 'phone'], 'string', 'max' => 255],
            [['name', 'surname', 'patronymic'], 'match', 'pattern' => '/^[а-яЁ\s\-]+$/iu', 'message' => 'можно использовать только: кириллица, пробел, тире'],
            ['login', 'match', 'pattern' => '/^[a-z\-]+$/i', 'message' => 'можно использовать только: латиница, тире'],
            ['email', 'email'],
            ['password', 'match', 'pattern' => '/^[a-z\d]+$/i', 'message' => 'можно использовать только: латиница, цифры'],
            ['password', 'string', 'length' => [6, 255], 'message' => 'минимальная длинна 6 символов'],
            ['passwordRep', 'compare', 'compareAttribute' => 'password'],

           // ['phone', 'match', 'pattern' => '/^\+7\([0-9]{3}\)\-[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/i', 'message' => 'телефон должен быть в формате +7(XXX)-XXX-XX-XX;'],
            ['rules', 'required', 'requiredValue' => 1, 'message' => 'Согласитесь на обработку персональных данных'],
            ['login', 'unique'],
            ['email', 'unique'],
            [['profilePhoto'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxSize' => 10000000],


        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'login' => 'Логин',
            'password' => 'Пароль',
            'passwordRep' => 'Повтор пароль',
            'email' => 'Email',
            'phone' => 'Номер телефона',
            'profilePhoto' => 'Фото',
            'rules' => 'Лиц соглашение',

            'isAdmin' => 'Is Admin',
            'authKey' => 'Auth Key',
        ];
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::class, ['authorId' => 'id']);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public static function findByUsername($login)
    {
        return static::findOne(['login' => $login]);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

   

    
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
           return false;
        }
        
        if($insert){
            {
            $this->authKey = Yii::$app->security->generateRandomString();
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
            $this->profilePhoto->saveAs('uploads/' . $this->profilePhoto->baseName . '.' . $this->profilePhoto->extension);
            $this->isAdmin = 0;
            $this->photoUrl = $this->profilePhoto;
        }
    }

        // ...custom code here...
        return true;
    }

}
