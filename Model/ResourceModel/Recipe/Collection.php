<?php
/**
 * Copyright (c) Alpina. All rights reserved.
 */

namespace Alpina\RecipesAndArticles\Model\ResourceModel\Recipe;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'recipe_id';
    protected $_eventPrefix = 'alpina_recipe_collection';
    protected $_eventObject = 'recipe_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Alpina\RecipesAndArticles\Model\Recipe::class,
            \Alpina\RecipesAndArticles\Model\ResourceModel\Recipe::class
        );
    }
}
