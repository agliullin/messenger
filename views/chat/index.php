
<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Collapse;
use app\models\User;
?>
<h1>Групповые чаты</h1>
<br>
<?php $form = ActiveForm::begin();?>
<?php

echo Html::a('Создать групповой чат', ['/chat/createchat/'], 
                   [
                       'class'=>'btn btn-primary'
                   ]);
echo '<br><br><br>';

foreach ($chats as $chat): {
$owner = User::findOne(['id'=>$chat->chat_owner]);
echo Collapse::widget([
    'items' => [
        [
            'label' => $chat->chat_name,
            'content' => '<b>Создатель</b>: '.$owner->name.' '.$owner->surname.' ('.$owner->email.')<br>'
            . '<b>Описание</b>: '.$chat->chat_desc.'<br><br>'
            . ''.Html::a('Войти', ['/chat/view/'.$chat->chat_id], 
                   [
                       'class' => 'btn-sm btn-info',
                       'style' => 'margin:5px'
                   ])
            ,
            'contentOptions' => [],
            'options' => [
                
            ]
        ]
    ]
]);
}
endforeach; 
?>
<?php $form = ActiveForm::end();?>