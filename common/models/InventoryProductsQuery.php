<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[InventoryProducts]].
 *
 * @see InventoryProducts
 */
class InventoryProductsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return InventoryProducts[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return InventoryProducts|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
