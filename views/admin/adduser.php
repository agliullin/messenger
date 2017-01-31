
<?php
use \yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php
if (Yii::$app->user->identity->role != 2) {
    echo '<center><h1>Вы не администратор!<h1></center>';   
} else {
?>
<h1>Добавление пользователя</h1>
<?php
$form = ActiveForm::begin(['class'=>'form-horizontal']);
?>
<?= $form->field($modeladd,'name')->textInput()->label('Имя')?>
<?= $form->field($modeladd,'surname')->textInput()->label('Фамилия')?>
<?= $form->field($modeladd,'email')->textInput()->label('Почта') ?>


<?= $form->field($modeladd,'password')->passwordInput()->label('Пароль')->hint('Длина пароля 6-32 символов.')?>

<?= Html::submitButton('Добавить', ['class' => 'btn btn-primary'])?>

<?php
    ActiveForm::end();
}
?>