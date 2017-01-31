<?php

namespace app\models;
use yii\base\Model;
use Yii;
class Signup extends Model
{
    public $email;
    public $password;
    public $name;
    public $surname;
    public function rules()
    {
        return [
            [['email','password','name','surname'],'required', message=>'Поле не заполнено'],
            ['email','email', message=> 'Некорректный адрес почты'],
            ['email','unique','targetClass'=>'app\models\User', message=> 'Пользователь с такой почтой уже зарегистрирован'],
            ['password','string','min'=>6, 'max'=>32, ]
        ];
    }
    public function signup()
    {
        $user = new User();
        $user->name = $this->name;
        $user->surname = $this->surname;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->status = 0;
        $user->role = 1;
        
        $user->generateAuthKey();
        $user->generateEmailConfirmToken();
        
        if ($user->save()) {
            Yii::$app->mailer->compose('emailConfirm', ['user' => $user])
                    ->setFrom('albertagliullinemailadm@yandex.ru')
                    ->setTo($this->email)
                    ->setSubject('Подтверждение почты для ' . Yii::$app->name)
                    ->send();
            return $user;
        }
        return null;
    }
}