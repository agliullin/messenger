<?php
namespace app\models;

use Yii;

class Chat extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'chat';
    }
    
}