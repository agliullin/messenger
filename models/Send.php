<?php

namespace app\models;
use yii\base\Model;
use yii;
use app\models\User;
class Send extends Model
{
    public $id;
    public $message;
    public $user_from;
    public $user_to;
    
    public function rules()
    {
        return [
            [['user_to','message'],'required', message=>'Поле не заполнено'],
            ['user_from','string'],
        ];
    }
    public function send()
    {
        $users = User::find()->where('id != :id', ['id'=>0])->all();
        if ($this->user_to == 0) {
            foreach ($users as $user):  {
                $dialog = new Dialog();
                $dialog->user_from = Yii::$app->user->identity->id;
                $dialog->message = $this->message;
                $dialog->is_new = 1;
                $dialog->user_from_del = 1;
                $dialog->user_to_del = 1;
                $dialog->user_to = $user->id;
                $dialog->save();
                $infosave = $dialog->save();
                if (!$infosave) {
                    return 0;
                } else {
                    Yii::$app->mailer->compose()
                    ->setFrom('albertagliullinemailadm@yandex.ru')
                    ->setTo($user->email)
                    ->setSubject('Новое сообщение! ' . Yii::$app->name.'.')
                    ->setTextBody('Здравствуйте, '.$user->name.' '.$user->surname.'! '
                            . 'У вас новое сообщение от '. Yii::$app->user->identity->name.' '.Yii::$app->user->identity->surname.'!')
                    ->send();
                }
                
            } endforeach;
            return 1;
        } else {
            $user = User::findOne(['id'=>$this->user_to]);
            $dialog = new Dialog();
            $dialog->user_from = Yii::$app->user->identity->id;
            $dialog->message = $this->message;
            $dialog->is_new = 1;
            $dialog->user_from_del = 1;
            $dialog->user_to_del = 1;
            $dialog->user_to = $this->user_to;
            if ($dialog->save()) {
                Yii::$app->mailer->compose()
                    ->setFrom('albertagliullinemailadm@yandex.ru')
                    ->setTo($user->email)
                    ->setSubject('Новое сообщение! ' . Yii::$app->name.'.')
                    ->setTextBody('Здравствуйте, '.$user->name.' '.$user->surname.'! '
                            . 'У вас новое сообщение от пользователя '. Yii::$app->user->identity->name.' '.Yii::$app->user->identity->surname.'!')
                    ->send();
                return 1;
            }
            else return 0;
        }
    }
}