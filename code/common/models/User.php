<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\Url;
use yii\web\UrlManager;

/**
 * User model
 *
 * @property integer $id
 * @property integer $id_city
 * @property string $name
 * @property string $sname
 * @property string $avatar_url
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $phone
 * @property integer $id_facebook
 * @property integer $id_vk
 * @property string $about_me
 * @property boolean $sex
 * @property integer $date_born
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @property City $city
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const ROLE_ADMIN = 'admin';

    const SEX_MALE = 0;
    const SEX_FEMALE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
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
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],

            ['name', 'string', 'max' => 30],
            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'required'],

            ['sname', 'string', 'max' => 30],
            ['sname', 'filter', 'filter' => 'trim'],

            ['email', 'email'],
            ['email', 'required'],
            ['email', 'string', 'max' => 255],

            ['phone', 'safe'],

            ['id_facebook', 'integer'],
            ['id_vk', 'integer'],

            ['about_me', 'string'],
            ['about_me', 'default'],

            ['sex', 'boolean'],
            ['sex', 'default'],

            ['date_born', 'integer'],
            ['date_born', 'default'],

            ['avatar_url', 'string'],

            ['id_city', 'integer'],
            ['id_city', 'default'],
        ];
    }

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
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * @param $id
     * @return null|User
     */
    public static function findById($id){
        return self::findOne(['id' => $id]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
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
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getCity(){
        return $this->hasOne(City::className(), ['id' => 'id_city']);
    }

    /**
     * @return bool|null|Organization
     * Возвращает организацию, которая вы создали, иначе false
     * !!! Предполагается, что у пользователя может быть максимуи одна организация
     */
    public function getMyOrg(){
        $org = Organization::findOne(['id_user' => $this->id]);
        if(!empty($org))
            return $org;
        return false;
    }

    public function getSex(){
        if(!isset($this->sex))
            return false;
        $sex = '';
        if($this->sex == self::SEX_MALE)
            $sex = 'мужской';
        elseif($this->sex == self::SEX_FEMALE)
            $sex = 'женский';
        return $sex;
    }

    public function getAllname(){
        $allname = $this->name . ' ' . $this->sname;
        return $allname;
    }

    /**
     * @return string
     * Возвращает Url страницы пользователя
     */
    public function getUrlProfile($id = null, $full = false){
        if(!isset($id))
            $url = Url::to(['user/index', 'id' => $this->id], $full);
        else $url = Url::to(['user/index', 'id' => $id], $full);
        return $url;
    }

    public function getVkUrl(){
        if(!empty($this->id_vk)){
            $url = "http://vk.com/id" . $this->id_vk;
            return $url;
        }
        return false;
    }

    public function getAvatarUrl(){
        if(!empty($this->avatar_url))
            return $this->avatar_url;
        return false;
    }

    public function getBornDate(){
        $date_born = Yii::$app->formatter->asDate($this->date_born);
        return $date_born;
    }

    public function isHaveOrg(){
        $count = Organization::find()
            ->where(['id_user' => $this->id])
            ->count();
        if($count > 0)
            return true;
        return false;
    }

    public function getUserTime(){
    }
}
