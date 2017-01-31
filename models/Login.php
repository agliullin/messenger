<?php

namespace app\models;
use yii\base\Model;
class Login extends Model
{
    public $email;
    public $password;
    public function rules()
    {
        return [
            [['email','password'],'required',message=>'Поле не заполнено'],
            ['email','email', message => 'Некорректный адрес почты'],
            ['password','validatePassword'] //собственная функция для валидации пароля
        ];
    }
    public function validatePassword($attribute,$params)
    {
        if(!$this->hasErrors()) // если нет ошибок в валидации
        {
            $user = $this->getUser(); // получаем пользователя для дальнейшего сравнения пароля
            // $this->addError($attribute, 'Пароль или почта введены неверно');
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('password', 'Неверный адрес почты или пароль.');
            } elseif ($user && $user->role == 0) {
                $this->addError('email', 'Ваш аккаунт заблокирован.');
            } elseif ($user && $user->status == 0) {
                $this->addError('email', 'Ваш аккаунт не подтвежден.');
            }
        }
    }
    public function getUser()
    {
        return User::findOne(['email'=>$this->email]); // а получаем мы его по введенному имейлу
    }
}