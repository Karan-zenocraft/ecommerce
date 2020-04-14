<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Chatlist]].
 *
 * @see Chatlist
 */
class ChatlistQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Chatlist[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Chatlist|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
