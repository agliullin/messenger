<?php
use \yii\widgets\ActiveForm;
use app\models\User;
use yii\helpers\ArrayHelper;
?>

<h1>Черный список</h1>
<?php
$form = ActiveForm::begin(['class'=>'form-horizontal']);
?>
<?php 
    $users = User::find()->where('id != :id', ['id'=>0])->andWhere('id != :myid', ['myid'=>Yii::$app->user->identity->id])->all();
// формируем массив, с ключем равным полю 'id' и значением равным полю 'email' 
    $items = ArrayHelper::map($users,'id','email');
    $params = [
        'prompt' => 'Выберите пользователя'
    ];
    echo $form->field($blacklist_model, 'black_id')->dropDownList($items,$params)->label('Пользователи');
?>
<div>
    <button type="submit" class="btn btn-primary" name="add" value="add">Добавить в ЧС</button>
    <button type="submit" class="btn btn-primary" name="delete" value="delete">Удалить из ЧС</button>
</div>
<br>

<?php
if ($blacklist_users != NULL) {
    echo '<br><b>Черный список</b>:';
    foreach ($blacklist_users as $blacklist_user):
    {
        $user = User::find()->where(['id'=>$blacklist_user->black_id])->one();
        echo '<p>'.$user->name.' '.$user->surname.'</p>';
    }
    endforeach;
} else echo '<br><b>Черный список пуст</b>';
?>
<?php
    ActiveForm::end();
?>