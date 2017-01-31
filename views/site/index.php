<?php 
use yii\helpers\Html;

if (Yii::$app->user->isGuest)  {
    echo '<center><h1>Мессенджер</h1><br>';
    echo 'Здравствуйте, <b>гость</b>! Для того, чтобы воспользоваться полным функционалом сайта необходимо зарегистрироваться или войти в свой аккаунт.<br><br>';
    echo Html::a('Авторизация', ['/site/login/'], 
                            [
                                'class' => 'btn btn-primary',
                                'style' => 'margin:5px'
                            ]
                        );
    
    echo Html::a('Регистрация', ['/site/signup/'], 
                            [
                                'class' => 'btn btn-primary',
                                'style' => 'margin:5px'
                            ]
                        );
    echo '</center>';
} else {
    echo '<center><h1>Мессенджер</h1><br>';
    echo 'Здравствуйте, <b>'.Yii::$app->user->identity->name.' '.Yii::$app->user->identity->surname.'</b>!<br><br>';
    echo Html::a('Начать диалог', ['/dialog/send/'], 
                            [
                                'class' => 'btn btn-primary',
                                'style' => 'margin:5px'
                            ]
                        );
    echo Html::a('Мои диалоги', ['/dialog/index/'], 
                            [
                                'class' => 'btn btn-primary',
                                'style' => 'margin:5px'
                            ]
                        );
    echo Html::a('Черный список', ['/dialog/index/'], 
                            [
                                'class' => 'btn btn-primary',
                                'style' => 'margin:5px'
                            ]
                        );
    echo Html::a('Групповые чаты', ['/chat/index/'], 
                            [
                                'class' => 'btn btn-primary',
                                'style' => 'margin:5px'
                            ]
                        );
}
if (Yii::$app->user->identity->role == 2) {
    echo Html::a('Панель администратора', ['/admin/index/'], 
                            [
                                'class' => 'btn btn-success',
                                'style' => 'margin:5px'
                            ]
                        );
}

echo '<br><br><br><br><br><br>';
echo Html::a('Информация', ['/site/info'], 
            [
                'class'=>'btn btn-primary', 
            ]);
?>