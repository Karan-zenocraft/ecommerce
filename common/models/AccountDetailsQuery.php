<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[AccountDetails]].
 *
 * @see AccountDetails
 */
class AccountDetailsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return AccountDetails[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AccountDetails|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
