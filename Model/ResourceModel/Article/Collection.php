<?php
/**
 * Copyright (c) Alpina. All rights reserved.
 */

namespace Alpina\RecipesAndArticles\Model\ResourceModel\Article;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'article_id';
    protected $_eventPrefix = 'alpina_article_collection';
    protected $_eventObject = 'article_collection';

    protected function _construct()
    {
        $this->_init(
            \Alpina\RecipesAndArticles\Model\Article::class,
            \Alpina\RecipesAndArticles\Model\ResourceModel\Article::class
        );
    }
}
