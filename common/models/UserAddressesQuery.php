<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[UserAddresses]].
 *
 * @see UserAddresses
 */
class UserAddressesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return UserAddresses[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return UserAddresses|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
