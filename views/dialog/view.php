<?php
use app\models\User;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<?php
foreach ($view_dialog as $dialog): {
if ($dialog->user_from == Yii::$app->user->identity->id) {
    $companion = User::findOne(['id'=>$dialog->user_to]);
    $youname = $dialog->companion_name = $companion->name;
    $yousurname = $dialog->companion_surname = $companion->surname;
    $youemail = $dialog->companion_email = $companion->email;
    $youid = $companion->id;
    $flag = 1;
    break;
} else if ($dialog->user_to == Yii::$app->user->identity->id) {
    $companion = User::findOne(['id'=>$dialog->user_from]);
    $youname = $dialog->companion_name = $companion->name;
    $yousurname = $dialog->companion_surname = $companion->surname;
    $youemail =$dialog->companion_email = $companion->email;
    $youid = $companion->id;
    $flag = 2;
    break;
}
}
endforeach; 
?>
<?php
$mename = Yii::$app->user->identity->name;
$mesurname = Yii::$app->user->identity->surname;
$meemail= Yii::$app->user->identity->email;
if ($flag == 2){
    $message = "<h1>Диалог c ".$dialog->companion_name." ".$dialog->companion_surname."</h1>";
    echo $message;
} else {
    $message = "<h1>Диалог c ".$dialog->companion_name." ".$dialog->companion_surname."</h1>";
    echo $message;
}
?>

<?php
$form = ActiveForm::begin(['class'=>'form-horizontal']);
?>
<?= $form->field($send_model,'message')->textarea()->label('Написать сообщение') ?>

<div>
    <button type="submit" class="btn btn-primary" name="send" value="send">Отправить</button>
</div>
<?php ActiveForm::end();?>

<br>
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
    .newcontent {
        background: #DCDCDC;
    width: 100%; /* Ширина слоя */
    text-align: right;
    }
    .notmycontent:hover {background: #DCDCDC}
    .mycontent:hover {background: #D3D3D3}
    
  </style>
<?php
foreach ($view_dialog as $dialog): {
    if ($dialog->user_from_del == 0 && $dialog->user_to_del == 0) {
        $delete = Yii::$app->db->createCommand("
                    DELETE FROM dialog 
                    WHERE id = '$dialog->id'
                ")->execute();
    }
    if ($dialog->user_from == Yii::$app->user->identity->id && $dialog->user_from_del == 1) {
        echo "<div class='mycontent'>".$mename." ".$mesurname." (".$meemail.")<br><b>".$dialog->message."</b><br>Дата: ".$dialog->time."<br>"
                . Html::a('Удалить', ['/dialog/view/'.$youid.'&delmy='.$dialog->id], 
                [
                    'class'=>'btn btn-success', 
                ])
                . "</div><br>";
    } else {
        if ($dialog->is_new == 1 && $dialog->user_to_del == 1 && $dialog->user_from != Yii::$app->user->identity->id) {
            echo "<div class='newcontent'><img src='/images/new.png' width='20' height='20' alt='lorem'><br>".
                    $youname." ".$yousurname." (".$youemail.")<br><b>".$dialog->message."</b><br>Дата: ".$dialog->time.
                    "<br>"
                    . Html::a('Удалить', ['/dialog/view/'.$youid.'&delnotmy='.$dialog->id], 
                        [
                            'class'=>'btn btn-success', 
                        ])
                    . "</div><br>";
        }
        else if ($dialog->user_to_del == 1 && $dialog->user_from != Yii::$app->user->identity->id) {
            echo "<div class='notmycontent'>".$youname." ".$yousurname." (".$youemail.")<br><b>".$dialog->message."</b><br>Дата: ".$dialog->time."<br>"
                    . Html::a('Удалить', ['/dialog/view/'.$youid.'&delnotmy='.$dialog->id], 
                        [
                            'class'=>'btn btn-success', 
                        ])
                    . "</div><br>";
        }
    }
    
    if ($dialog->user_to == Yii::$app->user->identity->id) {
        $dialog->is_new = 0;
        $dialog->save();
    }
}
endforeach; 
?>
