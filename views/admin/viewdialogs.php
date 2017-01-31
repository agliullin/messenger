<?php
use yii\helpers\Html;
use app\models\User;
use app\models\Dialog;
use yii\bootstrap\Button;
?>

<?php
if (Yii::$app->user->identity->role != 2) {
    echo '<center><h1>Вы не администратор!<h1></center>';   
} else {
?>
<h1>Диалоги пользователя: <?php echo $user->name.' '.$user->surname?></h1>
<br>
<?php
if ($dialogs == NULL) {
    echo '<b>Диалогов нет</b>';
}
$arr = array($user->id);
foreach ($dialogs as $dialog):  {
    if (!in_array($dialog->user_from, $arr)) {
        $arr[] = $dialog->user_from;
if ($dialog->user_from != $user->id) {
    $companion = User::findOne(['id'=>$dialog->user_from]);
    $dialog->companion_name = $companion->name;
    $dialog->companion_surname = $companion->surname;
    $dialog->companion_email = $companion->email;
} else {
    $companion = User::findOne(['id'=>$dialog->user_to]);
    $dialog->companion_name = $companion->name;
    $dialog->companion_surname = $companion->surname;
    $dialog->companion_email = $companion->email;
}
echo Html::a($dialog->companion_name.' '.$dialog->companion_surname, ['/admin/dialog/'.$user->id.'/'.$companion->id], 
        [
            'class'=>'btn btn-default', 
            'style' => 'width:100%',
        ]);
    echo '<br><br>';
    } 
    if (!in_array($dialog->user_to, $arr)) {
        $arr[]=$dialog->user_to;
        if ($dialog->user_from != $user->id) {
    $companion = User::findOne(['id'=>$dialog->user_from]);
    $dialog->companion_name = $companion->name;
    $dialog->companion_surname = $companion->surname;
    $dialog->companion_email = $companion->email;
} else {
    $companion = User::findOne(['id'=>$dialog->user_to]);
    $dialog->companion_name = $companion->name;
    $dialog->companion_surname = $companion->surname;
    $dialog->companion_email = $companion->email;
}
echo Html::a($dialog->companion_name.' '.$dialog->companion_surname, ['/admin/dialog/'.$user->id.'/'.$companion->id], 
        [
            'class'=>'btn btn-default', 
            'style' => 'width:100%',
        ]);
    echo '<br><br>';
    }
} endforeach;
}