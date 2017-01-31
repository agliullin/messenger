<?php
namespace app\models;

use Yii;

class Createchat extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'chatlist';
    }
    public function rules()
    {
        return [
            ['chat_id','string'],
            [['chat_name','chat_desc'],'required', message=>'Поле не заполнено']
        ];
    }
    public function createchat() {
        $chat = new Createchat();
        $chat->chat_name = $this->chat_name;
        $chat->chat_desc = $this->chat_desc;
        $chat->chat_owner = Yii::$app->user->identity->id;
        if ($chat->save()) {
            return $chat->chat_name;
        }
        return 0;
    }
}