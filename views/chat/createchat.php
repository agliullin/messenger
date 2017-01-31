<h1>Создание группового чата</h1>
<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin();?>

<?= $form->field($chat_model,'chat_name')->textInput()->label('Название группового чата')?>
<?= $form->field($chat_model,'chat_desc')->textInput()->label('Описание')?>


<?= Html::submitButton('Создать', ['class' => 'btn btn-primary'])?>

<?php $form = ActiveForm::end();?>