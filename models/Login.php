<?php

namespace app\models;


use yii\base\Model;


class Login extends Model
{
    public $mail;
    public $password;


    public function rules()
    {
        return [
            [['mail', 'password'], 'required'],
            ['password', 'validatePassword']
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) //если нет ошибок валидации
        {
            $user = Users::findOne(['mail' => $this->mail]);

            if (!$user || (true != password_verify($this->password, $user->password))) {
                //если не нашли такого пользователя или его пароль неверный неверный
                $this->addError($attribute, 'Логин или пароль введены неверно!');
            }
        }
    }

    public function findByEmail()
    {
        return Users::findOne(['mail' => $this->mail]);
    }

}