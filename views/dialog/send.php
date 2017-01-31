<h1>Отправка сообщения</h1>
<?php
use \yii\widgets\ActiveForm;
use app\models\User;
use yii\helpers\ArrayHelper;
?>
<?php
$form = ActiveForm::begin(['class'=>'form-horizontal']);
?>
<?php 
    $users = User::find()->all();
// формируем массив, с ключем равным полю 'id' и значением равным полю 'email' 
    $items = ArrayHelper::map($users,'id','email');
    $params = [
        'prompt' => 'Выберите пользователя'
    ];
    echo $form->field($send_model, 'user_to')->dropDownList($items,$params)->label('Получатель');
?>


<?= $form->field($send_model,'message')->textarea()->label('Сообщение') ?>

<div>

    <button type="submit" class="btn btn-primary">Отправить</button>
</div>

<?php
    ActiveForm::end();
?>