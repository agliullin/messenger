<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\models\User;
use app\models\Dialog;
use yii\bootstrap\Button;
use yii\bootstrap\Collapse;
?>
<h1>Диалоги</h1>
<br>
<?php
if ($dialogs == NULL) {
    echo '<b>Диалогов нет</b>';
}
$arr = array(Yii::$app->user->identity->id);
foreach ($dialogs as $dialog):  {
    if (!in_array($dialog->user_from, $arr)) {
        $arr[] = $dialog->user_from;
                    $flag = false;
                   foreach ($blacklist_users as $blacklist_user):
                   {
                       if ($blacklist_user->black_id == $dialog->user_from) {
                           $flag = true;
                       }
                   }
                   endforeach;
           $indexnew = 0;
           if ($dialog->user_from != Yii::$app->user->identity->id) {
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
           foreach ($newdialogs as $newdialog) : {
               if ($newdialog->user_from == $companion->id) {
                   $indexnew++;
               }   
           } endforeach;
           if ($indexnew > 0 && $flag == false) {
               echo Html::a($dialog->companion_name.' '.$dialog->companion_surname.' ('.$indexnew.')', ['/dialog/view/'.$companion->id], 
                   [
                       'class'=>'btn btn-info', 
                       'style' => 'width:100%',
                   ]);
               echo '<br><br>';
           } else if ($flag == false) {
               echo Html::a($dialog->companion_name.' '.$dialog->companion_surname, ['/dialog/view/'.$companion->id], 
                   [
                       'class'=>'btn btn-default', 
                       'style' => 'width:100%',
                   ]);
               echo '<br><br>';
           }
    }
    if (!in_array($dialog->user_to, $arr)) {
        $arr[]=$dialog->user_to;
                    $flag = false;
                   foreach ($blacklist_users as $blacklist_user):
                   {
                       if ($blacklist_user->black_id == $dialog->user_from) {
                           $flag = true;
                       }
                   }
                   endforeach;
           $indexnew = 0;
           if ($dialog->user_from != Yii::$app->user->identity->id) {
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
           foreach ($newdialogs as $newdialog) : {
               if ($newdialog->user_from == $companion->id) {
                   $indexnew++;
               }   
           } endforeach;
           if ($indexnew > 0 && $flag == false) {
               echo Html::a($dialog->companion_name.' '.$dialog->companion_surname.' ('.$indexnew.')', ['/dialog/view/'.$companion->id], 
                   [
                       'class'=>'btn btn-info', 
                       'style' => 'width:100%',
                   ]);
               echo '<br><br>';
           } else if ($flag == false) {
               echo Html::a($dialog->companion_name.' '.$dialog->companion_surname, ['/dialog/view/'.$companion->id], 
                   [
                       'class'=>'btn btn-default', 
                       'style' => 'width:100%',
                   ]);
               echo '<br><br>';
           }
    }
}
endforeach; 
?>
