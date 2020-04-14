<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[NotificationList]].
 *
 * @see NotificationList
 */
class NotificationListQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return NotificationList[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return NotificationList|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
