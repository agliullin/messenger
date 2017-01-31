<?php 
use yii\helpers\Html;
?>

<?php

if (Yii::$app->user->identity->role != 2) {
    echo '<center><h1>Вы не администратор!<h1></center>';   
} else {
?>
<h1>Пользователи</h1>
<br>
<?php
foreach ($users as $user):  {
    if ($user->role == 2) {
        echo Html::a($user->name.' '.$user->surname.' (Администратор)', ['/admin/viewuser/'.$user->id], 
            [
                'class'=>'btn btn-success', 
            ]);
        echo '<br><br>';
    } else if ($user->role == 1) {
        echo Html::a($user->name.' '.$user->surname.' (Пользователь)', ['/admin/viewuser/'.$user->id], 
            [
                'class'=>'btn btn-default', 
            ]);
        echo '<br><br>';
    } else if ($user->role == 0) {
        echo Html::a($user->name.' '.$user->surname.' (Забаненный)', ['/admin/viewuser/'.$user->id], 
            [
                'class'=>'btn btn-danger', 
            ]);
        echo '<br><br>';
    }
} endforeach;



}
?>
