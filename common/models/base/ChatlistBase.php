<?php

namespace common\models\base;

use common\models\ChatlistQuery;
use common\models\Users;
use Yii;

/**
 * This is the model class for table "chat_list".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $chat_user_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Users $chatUser
 * @property Users $user
 */
class ChatlistBase extends \yii\db\ActiveRecord
{
/**
 * @inheritdoc
 */
    public static function tableName()
    {
        return 'chat_list';
    }

/**
 * @inheritdoc
 */
    public function rules()
    {
        return [
            [['user_id', 'chat_user_id', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'chat_user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['chat_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['chat_user_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

/**
 * @inheritdoc
 */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'chat_user_id' => 'Chat User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'chat_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return ChatlistQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ChatlistQuery(get_called_class());
    }
}
