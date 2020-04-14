<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ProductPhotos]].
 *
 * @see ProductPhotos
 */
class ProductPhotosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ProductPhotos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProductPhotos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
