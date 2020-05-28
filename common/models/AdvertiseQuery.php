<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Advertise]].
 *
 * @see Advertise
 */
class AdvertiseQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Advertise[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Advertise|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
