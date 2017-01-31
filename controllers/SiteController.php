<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\ContactForm;


use app\models\Signup;
use app\models\Login;
use app\models\EmailConfirmForm;

use app\models\Blacklist;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if(!Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }
        $login_model = new Login();
        if( Yii::$app->request->post('Login'))
        {
            $login_model->attributes = Yii::$app->request->post('Login');
            if($login_model->validate())
            {
                Yii::$app->user->login($login_model->getUser());
                return $this->goHome();
            }
        }
        return $this->render('login',['login_model'=>$login_model]);
    }
    
    
    public function actionSignup()
    {
        $model = new Signup();
        if(isset($_POST['Signup']))
        {
            $model->attributes = Yii::$app->request->post('Signup');
            if($model->validate() && $model->signup())
            {
                Yii::$app->session->addFlash('success', 'Подтвердите почту!');
            }
        }
        return $this->render('signup',['model'=>$model]);
    }

    
    
    
    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        if(!Yii::$app->user->isGuest)
        {
            Yii::$app->user->logout();
            return $this->redirect(['login']);
        }
    }
    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    public function actionBlacklist() {
        
        $blacklist_users = Blacklist::find()->where(['owner_id' => Yii::$app->user->identity->id])->all();
        $blacklist_model = new Blacklist();
        if(isset($_POST['add']))
        {
            $blacklist_model->attributes = Yii::$app->request->post('Blacklist');
            $users = Blacklist::find()->where(['owner_id' => Yii::$app->user->identity->id])->all();
            $flag = false;
            foreach ($users as $owner):
            if ($owner->black_id == $blacklist_model->black_id) {
                Yii::$app->session->addFlash('danger', 'Пользователь уже в ЧС!');
                $flag = true;
                break;
            }
            endforeach;
            if ($flag != true) {
                $blacklist_model->owner_id = Yii::$app->user->identity->id;
                if ($blacklist_model->save()) {
                    Yii::$app->session->addFlash('success', 'Пользователь успешно добавлен в ЧС!');
                    return $this->refresh();
                }
                else {
                    Yii::$app->session->addFlash('danger', 'Пользователь не добавлен в ЧС! (Неизвестная ошибка)');
                    return $this->refresh();
                }
            }
        }
        if(isset($_POST['delete']))
        {
            $blacklist_model->attributes = Yii::$app->request->post('Blacklist');
            $users = Blacklist::find()->where(['owner_id' => Yii::$app->user->identity->id])->all();
            $flag = false;
            foreach ($users as $owner):
            if ($owner->black_id == $blacklist_model->black_id) {
                $i = Yii::$app->user->identity->id;
                $j = $owner->black_id;
                $deletemodel = Yii::$app->db->createCommand("
                    DELETE FROM blacklist 
                    WHERE owner_id = '$i' 
                    AND black_id = '$j'
                ")->execute();
                Yii::$app->session->addFlash('success', 'Пользователь успешно удален из ЧС!');
                $flag = true;
                break;
            }
            endforeach;
            if ($flag == false) {
                Yii::$app->session->addFlash('danger', 'Пользователя нет в ЧС!');
            }
            return $this->refresh();
        }
        return $this->render('blacklist',[
                'blacklist_model'=>$blacklist_model,
                'blacklist_users' => $blacklist_users
            ]);
    }
    
    
    
    public function actionEmailConfirm($token)
    {
        try {
            $model = new EmailConfirmForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
 
        if ($model->confirmEmail()) {
            Yii::$app->session->addFlash('success', 'Спасибо! Ваш Email успешно подтверждён.');
            return $this->redirect(['login']);
        } else {
            Yii::$app->session->addFlash('danger', 'Ошибка подтверждения Email.');
        }
 
        return $this->goHome();
    }
    
    
    public function actionInfo() {
        return $this->render('info');
    }
    
    
}
