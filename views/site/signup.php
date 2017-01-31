<h1>Регистрация</h1>
<?php
use \yii\widgets\ActiveForm;
?>
<?php
    $form = ActiveForm::begin(['class'=>'form-horizontal']);
?>
<?= $form->field($model,'name')->textInput()->label('Имя')?>
<?= $form->field($model,'surname')->textInput()->label('Фамилия')?>
<?= $form->field($model,'email')->textInput()->label('Почта') ?>


<?= $form->field($model,'password')->passwordInput()->label('Пароль')->hint('Длина пароля 6-32 символов.')?>

<div>

    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
</div>

<?php
    ActiveForm::end();
?>