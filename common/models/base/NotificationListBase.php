<?php

namespace common\models\base;

use common\models\NotificationListQuery;
use common\models\Users;
use Yii;

/**
 * This is the model class for table "notification_list".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $body
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Users $user
 */
class NotificationListBase extends \yii\db\ActiveRecord
{
/**
 * @inheritdoc
 */
    public static function tableName()
    {
        return 'notification_list';
    }

/**
 * @inheritdoc
 */
    public function rules()
    {
        return [
            [['user_id', 'title', 'body', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['body'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
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
            'title' => 'Title',
            'body' => 'Body',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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
     * @return NotificationListQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NotificationListQuery(get_called_class());
    }
}
