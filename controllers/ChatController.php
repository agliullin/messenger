<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\Createchat;
use app\models\User;
use app\models\Chat;

class ChatController extends Controller
{
    public function actionIndex() {
        $chats = Createchat::find()->all();
        return $this->render('index',
                [
                  'chats'=>$chats  
                ]);
    }
    public function actionCreatechat() {
        $chat_model = new Createchat();
        if (Yii::$app->request->post('Createchat')) {
            $chat_model->attributes = Yii::$app->request->post('Createchat');
            if($chat_model->validate() && $chat_model->createchat())
            {
                Yii::$app->session->addFlash('success', 'Групповой чат успешно создан!');
            }
        }
        return $this->render('createchat',
                [
                    'chat_model'=>$chat_model
                ]);
    }
    public function actionView($chat_id) {
        $new_message = new Chat();
        
        if (isset($_POST['Chat'])) {
            $new_message->user_message = $_POST['Chat']['user_message'];
            $new_message->chat_id = $chat_id;
            $new_message->user_id = Yii::$app->user->identity->id;
            $new_message->user_name = Yii::$app->user->identity->name;
            $new_message->user_surname = Yii::$app->user->identity->surname;
            $new_message->user_email = Yii::$app->user->identity->email;
            if($new_message->validate() && $new_message->save())
            {
                Yii::$app->session->addFlash('success', 'Сообщение отправлено!');
            }
        }
        $chat = Createchat::findOne(['chat_id'=>$chat_id]);
        $messages = Chat::find()->orderBy('message_date DESC')->where(['chat_id'=>$chat_id])->all();
        return $this->render('view',
                [
                    'messages'=>$messages,
                    'new_message'=>$new_message,
                    'chat'=>$chat
                ]);
    }
}