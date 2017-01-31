<?php
use yii\bootstrap\Tabs;
use yii\helpers\Html;

if (Yii::$app->user->identity->role != 2) {
    echo '<center><h1>Вы не администратор!<h1></center>';   
} else {
    echo '<h1>Панель администратора</h1>';
    echo 'Здравствуйте, <b>'.Yii::$app->user->identity->name.' '.Yii::$app->user->identity->surname.'</b>. ';
    echo 'Добро пожаловать в панель администратора!<br><br>';
    echo Tabs::widget([
        'items' => [
            [
                'label' => 'Информация',
                'content' => '<br>Здесь вы можете управлять пользователями и их диалогами!',
                'active' => true
            ],
            [
                'label' => 'Пользователи',
                'content' => '<br>Перейдя по кнопке "Пользователи", вы сможете редактировать и удалять пользователей!<br><br>'.
                Html::a('Пользователи', ['/admin/users/'], 
                            [
                                'class' => 'btn btn-primary',
                                'style' => 'margin:5px'
                            ]
                        ).' '.
                Html::a('Добавить пользователя', ['/admin/adduser/'], 
                            [
                                'class' => 'btn btn-primary',
                                'style' => 'margin:5px'
                            ]
                        ).''
            ],
            [
                'label' => 'Диалоги',
                'content' => '<br>Перейдя по кнопке "Диалоги", вы сможете просматривать диалоги любых пользоватлей!<br><br>'.
                Html::a('Диалоги', ['/admin/dialogs/'], 
                            [
                                'class' => 'btn btn-primary',
                                'style' => 'margin:5px'
                            ]
                        ).' '.
                Html::a('Написать сообщение', ['/admin/addmessage/'], 
                            [
                                'class' => 'btn btn-primary',
                                'style' => 'margin:5px'
                            ]
                        ).''
            ],
        ]
    ]);
    
} ?>


