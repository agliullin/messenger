<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;

use app\models\User;
use app\models\Dialog;
use app\models\Signup;
use app\models\Send;

class AdminController extends Controller
{
    public function actionIndex() {
        return $this->render('index');
    }
    
    public function actionUsers() {
        $users = User::find()->where('id != :id', ['id'=>0])->all();
        return $this->render('users',
                [
                    'users'=>$users
                ]);
    }
    public function actionDialogs() {
        $users = User::find()->where('id != :id', ['id'=>0])->all();
        return $this->render('dialogs',
                [
                    'users'=>$users
                ]);
    }
    public function actionViewuser($id) {
        $user = User::findOne(['id'=>$id]);
        if(isset($_POST['User'])) {
            $user->name = $_POST['User']['name'];
            $user->surname = $_POST['User']['surname'];
            $user->role = $_POST['User']['role'];
            $user->email = $_POST['User']['email'];
            if ($user->validate() && $user->save()) {
                Yii::$app->session->addFlash('success', 'Информация сохранена!');
            } else Yii::$app->session->addFlash('danger', 'Не удалось сохранить информацию!');
        }
        if(isset($_POST['deleteuser'])) {
            $deleteuser = Yii::$app->db->createCommand("
                    DELETE FROM user 
                    WHERE id = '$id'");
            if ($deleteuser->execute()) {
                Yii::$app->session->addFlash('success', 'Пользователь успешно удален!');
            } else Yii::$app->session->addFlash('danger', 'Ошибка удаления пользователя!');
        }
        return $this->render('viewuser',
                [
                    'user'=>$user
                ]);
    }
    public function actionViewdialogs($id) {
        $dialogquery = Dialog::find();
        $user = User::findOne(['id'=>$id]);
        $dialogs = $dialogquery->orderBy(['time' => SORT_DESC])
            ->where(['user_to' => $id])
            ->orWhere(['user_from' => $id])
            ->orFilterWhere(['and',
            ['user_to' => $id],
            ['user_from' => $id]])
            ->all();
        return $this->render('viewdialogs', [
            'dialogs' => $dialogs,
            'user'=>$user
        ]);
    }
    public function actionDialog($user_from,$user_to,$delmy = NULL, $delnotmy = NULL) {
        $query = Dialog::find();
        $view_dialog = $query->orderBy('time DESC')
            ->orFilterWhere(['and',
            ['user_to' => $user_to],
            ['user_from' => $user_from]])
            ->orFilterWhere(['and',
            ['user_to' => $user_from],
            ['user_from' => $user_to]])
            ->all(); 
        
        $delmy = Yii::$app->request->get('delmy');
        $delnotmy = Yii::$app->request->get('delnotmy');
        if ($delmy != NULL) {
            $message = Dialog::findOne(['id'=>$delmy]);
            $message->user_from_del = 0;
            if ($message->save()) {
                $delmy = NULL;
                Yii::$app->session->addFlash('info', 'Сообщение удалено!');
                return $this->redirect('/web/admin/dialog/'.$user_from.'/'.$user_to);
            } else Yii::$app->session->addFlash('danger', 'Ошибка! Сообщение не удалено!');
        }
        if ($delnotmy != NULL) {
            $message = Dialog::findOne(['id'=>$delnotmy]);
            $message->user_to_del = 0;
            if ($message->save()) {
                $delnotmy = NULL;
                Yii::$app->session->addFlash('info', 'Сообщение удалено!');
                return $this->redirect('/web/admin/dialog/'.$user_from.'/'.$user_to);
            } else Yii::$app->session->addFlash('danger', 'Ошибка! Сообщение не удалено!');
        }
        
        
        $user = User::findOne(['id'=>$user_from]);  
                
             
        return $this->render('dialog', [
            'view_dialog' => $view_dialog,
            'user' => $user,
            'user_from' => $user_from,
            'user_to' => $user_to
        ]);
    }
    public function actionAdduser() {
        $modeladd = new Signup();
        if(isset($_POST['Signup']))
        {
            $modeladd->attributes = Yii::$app->request->post('Signup');
            if($modeladd->validate() && $modeladd->signup())
            {
                Yii::$app->session->addFlash('success', 'Пользователь успешно добавлен!');
            } else {
                Yii::$app->session->addFlash('danger', 'Пользователь не добавлен!');
            }
        } 
        return $this->render('adduser',['modeladd'=>$modeladd]);
    }
    public function actionAddmessage() {
        
        $send_model = new Send();
        if( Yii::$app->request->post('Send'))
        {
            $send_model->attributes = Yii::$app->request->post('Send');
            $users = User::find()->where('id != :id', ['id'=>0])->all();
            if ($send_model->user_to == 0) {
                foreach ($users as $user):  {
                    $dialog = new Dialog();
                    $dialog->user_from = $send_model->user_from;
                    $dialog->user_to = $user->id;
                    $dialog->message = $send_model->message;
                    $dialog->is_new = 1;
                    $dialog->user_from_del = 1;
                    $dialog->user_to_del = 1;
                    $dialog->save();
                    $infosave = $dialog->save();
                    if (!$infosave)
                    Yii::$app->session->addFlash('danger', 'Письмо не отправлено!');
                } endforeach;
                Yii::$app->session->addFlash('info', 'Письмо отправлено!');
            } else {
                $dialog = new Dialog();
                $dialog->user_from = $send_model->user_from;
                $dialog->user_to = $send_model->user_to;
                $dialog->message = $send_model->message;
                $dialog->is_new = 1;
                $dialog->user_from_del = 1;
                $dialog->user_to_del = 1;
                if ($dialog->save())
                    Yii::$app->session->addFlash('info', 'Письмо отправлено!');
                else 
                Yii::$app->session->addFlash('danger', 'Письмо не отправлено!');
            }
        }
        
        
        return $this->render('addmessage',[
            'send_model'=>$send_model,
        ]);
    }
}