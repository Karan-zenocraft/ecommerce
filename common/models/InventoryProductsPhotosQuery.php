<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[InventoryProductsPhotos]].
 *
 * @see InventoryProductsPhotos
 */
class InventoryProductsPhotosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return InventoryProductsPhotos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return InventoryProductsPhotos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
