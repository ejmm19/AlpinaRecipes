<?php
/**
 * Copyright (c) Alpina. All rights reserved.
 */

namespace Alpina\RecipesAndArticles\Model;

use Magento\Framework\Model\AbstractModel;

class Article extends AbstractModel
{
    const CACHE_TAG = 'alpina_article';

    protected $_cacheTag = 'alpina_article';
    protected $_eventPrefix = 'alpina_article';

    protected function _construct()
    {
        $this->_init(\Alpina\RecipesAndArticles\Model\ResourceModel\Article::class);
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getArticleId()
    {
        return $this->getData('article_id');
    }

    public function getTitle()
    {
        return $this->getData('title');
    }

    public function getUrlKey()
    {
        return $this->getData('url_key');
    }

    public function setArticleId($articleId)
    {
        return $this->setData('article_id', $articleId);
    }

    public function setTitle($title)
    {
        return $this->setData('title', $title);
    }

    public function setUrlKey($urlKey)
    {
        return $this->setData('url_key', $urlKey);
    }
}
