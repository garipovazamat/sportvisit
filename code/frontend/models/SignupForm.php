<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $is_organizator;

    public $avatar_url;
    public $sname;
    public $sex;
    public $date_born;
    public $phone;
    public $id_city;
    public $id_vk;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Эта почта уже используется'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['is_organizator', 'safe'],

            ['sname', 'default'],

            ['sex', 'boolean'],
            ['sex', 'default'],

            ['date_born', 'default'],

            ['phone', 'default'],

            ['avatar_url', 'default'],

            ['id_vk', 'integer'],
            ['id_vk', 'default'],

            ['id_city', 'integer'],
            ['id_city', 'default'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Электронная почта',
            'password' => 'Пароль',
            'username' => 'Имя',
            'is_organizator' => 'Вы являетесь организатором?',
            'sname' => 'Фамилия',
            'sex' => 'Пол',
            'phone' => 'Номер телефона',
            'id_city' => 'Ваш город',
        ];
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
            $user->name = $this->username;
            $user->email = $this->email;
            $user->sex = $this->sex;
            $user->avatar_url = $this->avatar_url;
            $user->sname = $this->sname;
            $user->phone = $this->phone;
            $user->id_city = $this->id_city;
            if(!empty($this->date_born))
                $user->date_born = strtotime($this->date_born);
            $user->id_vk = $this->id_vk;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
            else return $user;
        }
        return null;
    }
}
