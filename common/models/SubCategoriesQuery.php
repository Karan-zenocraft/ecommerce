<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[SubCategories]].
 *
 * @see SubCategories
 */
class SubCategoriesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SubCategories[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SubCategories|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
