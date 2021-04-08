<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $mail
 * @property string $password
 * @property string $name_surname
 * @property int $behaviors
 */
class Users extends \yii\db\ActiveRecord implements IdentityInterface
{
    private static $user;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mail', 'password', 'name_surname'], 'required'],
            [['behaviors'], 'integer'],
            [['mail', 'password', 'name_surname'], 'string', 'max' => 255],
            [['mail'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mail' => 'e-mail',
            'password' => 'Пароль',
            'name_surname' => 'Объект',
            'behaviors' => 'Права',
        ];
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getId()
    {
        return $this->id;
    }
    public function getBehaviors()
    {
        return $this->behaviors;
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function getEsp()
    {
        return $this->hasMany(Esp::className(), ['id' => 'user_id']);
    }

    public function getEspMarket()
    {
        return $this->hasMany(Esp::className(), ['id' => 'market_point']);
    }

    public function getManager()
    {
        return $this->hasMany(Esp::className(), ['id' => 'manager_id']);
    }

    public function getBehaviorList()
    {
        return [
            15 => 'Торговый представитель',
            10 => 'Продавец',
            5 => 'Торговая точка',
            1 => 'Админ'];
    }
}
