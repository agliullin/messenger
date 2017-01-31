<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

use app\models\Dialog;
use app\models\Send;
use yii\data\Pagination;

use app\models\Blacklist;
class DialogController extends Controller
{
    public function actionIndex()
    {
        $dialogquery = Dialog::find();

        $dialogs = $dialogquery->orderBy(['time' => SORT_DESC])
            ->offset($pagination->offset)
            ->where(['user_to' => Yii::$app->user->identity->id])
            ->orWhere(['user_from' => Yii::$app->user->identity->id])
            ->orFilterWhere(['and',
            ['user_to' => Yii::$app->user->identity->id],
            ['user_from' => Yii::$app->user->identity->id]])
            ->all();
        
        $newdialogquery = Dialog::find();
        $newdialogs = $newdialogquery->where(['user_to' => Yii::$app->user->identity->id])
            ->andWhere(['is_new' => 1])
            ->all();
        
        $pagination = new Pagination([
            'defaultPageSize' => 20,
            'totalCount' => $dialogquery->count(),
        ]);
        
        
        
        $blacklist_users = Blacklist::find()->where(['owner_id'=>Yii::$app->user->identity->id])->all();
        
        return $this->render('index', [
            'dialogs' => $dialogs,
            'pagination' => $pagination,
            'newdialogs' => $newdialogs,
            'blacklist_users'=> $blacklist_users
        ]);
    }
    public function actionSend()
    {
        $send_model = new Send();
        if( Yii::$app->request->post('Send'))
        {
            $send_model->attributes = Yii::$app->request->post('Send');
            if($send_model->validate() && $send_model->send())
            {
                Yii::$app->session->addFlash('info', 'Письмо отправлено!');
            } else
            Yii::$app->session->addFlash('danger', 'Письмо не отправлено!');
        }
        
        
        return $this->render('send',[
            'send_model'=>$send_model,
        ]);
    }
    
    public function actionView($user_from, $delmy = NULL, $delnotmy = NULL) {
        $query = Dialog::find();
        $view_dialog = $query->orderBy('time DESC')
            ->orFilterWhere(['and',
            ['user_to' => Yii::$app->user->identity->id],
            ['user_from' => $user_from]])
            ->orFilterWhere(['and',
            ['user_to' => $user_from],
            ['user_from' => Yii::$app->user->identity->id]])
            ->all();  
        $delmy = Yii::$app->request->get('delmy');
        $delnotmy = Yii::$app->request->get('delnotmy');
        if ($delmy != NULL) {
            $message = Dialog::findOne(['id'=>$delmy]);
            $message->user_from_del = 0;
            if ($message->save()) {
                $delmy = NULL;
                Yii::$app->session->addFlash('info', 'Сообщение удалено!');
                return $this->redirect('/web/dialog/view/'.$user_from);
            } else Yii::$app->session->addFlash('danger', 'Ошибка! Сообщение не удалено!');
        }
        if ($delnotmy != NULL) {
            $message = Dialog::findOne(['id'=>$delnotmy]);
            $message->user_to_del = 0;
            if ($message->save()) {
                $delnotmy = NULL;
                Yii::$app->session->addFlash('info', 'Сообщение удалено!');
                return $this->redirect('/web/dialog/view/'.$user_from);
            } else Yii::$app->session->addFlash('danger', 'Ошибка! Сообщение не удалено!');
        }
        
        $send_model = new Send();
        if( Yii::$app->request->post('Send'))
        {
            $send_model->attributes = Yii::$app->request->post('Send');
            $send_model->user_to = $user_from;
            if($send_model->validate() && $send_model->send())
            {
                Yii::$app->session->addFlash('info', 'Письмо отправлено!');
                return $this->refresh();
            } else
            Yii::$app->session->addFlash('danger', 'Письмо не отправлено!');
        }
        return $this->render('view', [
            'view_dialog' => $view_dialog,
            'send_model' => $send_model,
        ]);
    }
}


	