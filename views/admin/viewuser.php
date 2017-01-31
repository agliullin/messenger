<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<?php
if (Yii::$app->user->identity->role != 2) {
    echo '<center><h1>Вы не администратор!<h1></center>';   
} else {
?>
<h1>Просмотр профиля: <?= $user->name.' '.$user->surname?>.</h1>

<?php $form = ActiveForm::begin(); ?>
 
<?= $form->field($user, 'name')->textInput()->label('Имя') ?>
<?= $form->field($user, 'surname')->textInput()->label('Фамилия') ?>
<?= $form->field($user, 'email')->textInput()->label('Почта') ?>
<?= $form->field($user, 'role')->textInput()->label('Роль')->hint('0 - Забаненный<br>1 - Пользователь<br>2 - Администратор<br>') ?>

<?= Html::submitButton('Сохранить', ['class' => 'btn btn-info','name'=>'saveuser']) ?> 
<?= Html::submitButton('Удалить пользователя', ['class' => 'btn btn-danger','name'=>'deleteuser']) ?>
    
<?php ActiveForm::end(); ?>
<?php
}

?>

