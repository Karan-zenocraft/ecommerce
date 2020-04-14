<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Wishlist]].
 *
 * @see Wishlist
 */
class WishlistQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Wishlist[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Wishlist|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
