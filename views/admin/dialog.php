<?php
use app\models\User;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

<?php
if (Yii::$app->user->identity->role != 2) {
    echo '<center><h1>Вы не администратор!<h1></center>';   
} else {
?>
<?php
foreach ($view_dialog as $dialog): {
if ($dialog->user_from == $user->id) {
    $companion = User::findOne(['id'=>$dialog->user_to]);
    $youname = $dialog->companion_name = $companion->name;
    $yousurname = $dialog->companion_surname = $companion->surname;
    $youemail = $dialog->companion_email = $companion->email;
    $youid = $companion->id;
    $flag = 1;
    break;
} else if ($dialog->user_to == $user->id) {
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
$mename = $user->name;
$mesurname = $user->surname;
$meemail= $user->email;
if ($flag == 2){
    $message = "<h1>Диалог ".$mename." ".$mesurname." c ".$dialog->companion_name." ".$dialog->companion_surname."</h1>";
    echo $message;
} else {
    $message = "<h1>Диалог ".$mename." ".$mesurname." c ".$dialog->companion_name." ".$dialog->companion_surname."</h1>";
    echo $message;
}
?>
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
    
    if ($dialog->user_from == $user->id && $dialog->user_from_del == 1) {
        echo "<div class='mycontent'>".$mename." ".$mesurname." (".$meemail.")<br><b>".$dialog->message."</b><br>Дата: ".$dialog->time."<br>"
                . Html::a('Удалить', ['/admin/dialog/'.$user->id.'/'.$youid.'&delmy='.$dialog->id], 
                [
                    'class'=>'btn btn-success', 
                ])
                . "</div><br>";
    } else {
        if ($dialog->is_new == 1 && $dialog->user_to_del == 1 && $dialog->user_from != $user->id) {
            echo "<div class='newcontent'><img src='/images/new.png' width='20' height='20' alt='lorem'><br>".
                    $youname." ".$yousurname." (".$youemail.")<br><b>".$dialog->message."</b><br>Дата: ".$dialog->time.
                    "<br>".Html::a('Удалить', ['/admin/dialog/'.$user->id.'/'.$youid.'&delnotmy='.$dialog->id], 
                        [
                            'class'=>'btn btn-success', 
                        ])
                    . "</div><br>";
        }
        else if ($dialog->user_to_del == 1 && $dialog->user_from != $user->id) {
            echo "<div class='notmycontent'>".$youname." ".$yousurname." (".$youemail.")<br><b>".$dialog->message."</b><br>Дата: ".$dialog->time."<br>"
                    . Html::a('Удалить', ['/admin/dialog/'.$user->id.'/'.$youid.'&delnotmy='.$dialog->id], 
                        [
                            'class'=>'btn btn-success', 
                        ])
                    . "</div><br>";
        }
    }
    
}
endforeach; 
}
?>
