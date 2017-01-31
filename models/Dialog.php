<?php
namespace app\models;

use Yii;

class Dialog extends \yii\db\ActiveRecord
{
    public $companion_name;
    public $companion_surname;
    public $companion_email;
    public static function tableName()
        {
            return 'dialog';
        }
}