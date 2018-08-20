<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 05.03.16
 * Time: 15:51
 */

namespace frontend\models;


use common\models\User;
use yii\base\Model;

class UserForm extends Model
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $sname;
    public $sex;
    public $date_born;
    public $phone;
    public $about_me;
    public $id_city;

    public function rules()
    {
        return [
            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'required'],
            ['name', 'string', 'min' => 2, 'max' => 255],

            ['sname', 'filter', 'filter' => 'trim'],
            ['sname', 'string'],
            ['sname', 'default', 'value' => null],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Эта почта уже используется', 'filter' => 'id != '.$this->id],

            ['password', 'string', 'min' => 6],

            ['sex', 'boolean'],
            ['sex', 'default', 'value' => null],

            ['phone', 'string'],
            ['phone', 'default', 'value' => null],

            ['date_born', 'date', 'format' => 'yyyy-mm-dd'],
            ['date_born', 'default', 'value' => null],

            ['about_me', 'string'],
            ['about_me', 'default', 'value' => null],

            ['id_city', 'integer'],
            ['id_city', 'default'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'sname' => 'Фамилия',
            'email' => 'Адрес электронной почты',
            'sex' => 'Пол',
            'date_born' => 'Дата рождения',
            'phone' => 'Номер телефона',
            'about_me' => 'О себе',
            'id_city' => 'Город',
        ];
    }

    /**
     * @return User
     */
    public function loadUser($id){
        $user = User::findById($id);

        if(!empty($user->date_born))
            $user->date_born = date('Y-m-d', $user->date_born);

        $this->id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->sname = $user->sname;
        $this->sex = $user->sex;
        $this->date_born = $user->date_born;
        $this->phone = $user->phone;
        $this->about_me = $user->about_me;
        $this->id_city = $user->id_city;
        return $user;
    }

    /**
     * @param $user User
     * @return User
     */
    public function updateUser($user){

        $this->about_me = strip_tags($this->about_me);

        $user->name = $this->name;
        $user->sname = $this->sname;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->about_me = $this->about_me;
        $user->sex = $this->sex;
        $user->id_city = $this->id_city;
        if(isset($this->date_born))
            $user->date_born = strtotime($this->date_born);
        if(!empty($this->password))
            $user->setPassword($this->password);

        return $user->update();
    }

}