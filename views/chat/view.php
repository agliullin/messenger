<?php
use \yii\widgets\ActiveForm;
use app\models\User;
use yii\helpers\ArrayHelper;
?>
<h1>Групповой чат</h1>
Название: <b><?= $chat->chat_name?></b><br>
Описание: <b><?= $chat->chat_desc?></b><br><br>
<?php
$form = ActiveForm::begin(['class'=>'form-horizontal']);
?>
<?= $form->field($new_message,'user_message')->textarea()->label('Написать сообщение') ?>

<div>
    <button type="submit" class="btn btn-primary">Отправить</button>
</div>
<style>
    #left { text-align: left; }
    #right { text-align: right; }
    #center { text-align: center; }
    .mycontent {
    width: 100%; /* Ширина слоя */
    text-align: left; 
    }
    .notmycontent {
    width: 100%; /* Ширина слоя */
    text-align: right;
    }
    .notmycontent:hover {background: #DCDCDC}
    .mycontent:hover {background: #D3D3D3}
    
  
  </style>

<?php
echo '<br>';
foreach ($messages as $message): {
if ($message->user_id != Yii::$app->user->identity->id) {
    $companion_name = $message->user_name;
    $companion_surname = $message->user_surname;
    $companion_email = $message->user_email;
    $companion_date = $message->message_date;
    $companion_message = $message->user_message;
    echo "<div class='notmycontent'>".$companion_name." ".$companion_surname." (".$companion_email.")<br><b>".$companion_message."</b><br>Дата: ".$companion_date."<br></div><br>";
    
} else {
    $my_name = $message->user_name;
    $my_surname = $message->user_surname;
    $my_email = $message->user_email;
    $my_date = $message->message_date;
    $my_message = $message->user_message;
    echo "<div class='mycontent'>".$my_name." ".$my_surname." (".$my_email.")<br><b>".$my_message."</b><br>Дата: ".$my_date."<br></div><br>";
}
}
endforeach; 
?>
<?php
    ActiveForm::end();
?>