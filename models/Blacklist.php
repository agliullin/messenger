<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
class Blacklist extends ActiveRecord {
    public function rules()
    {
        return [
            [['black_id'],'required', message=>'Поле не заполнено']
        ];
    }
    public static function tableName()
        {
            return 'blacklist';
        } 
   
}