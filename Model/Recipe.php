<?php
/**
 * Copyright (c) Alpina. All rights reserved.
 */

namespace Alpina\RecipesAndArticles\Model;

use Magento\Framework\Model\AbstractModel;

class Recipe extends AbstractModel
{
    const CACHE_TAG = 'alpina_recipe';

    protected $_cacheTag = 'alpina_recipe';

    protected $_eventPrefix = 'alpina_recipe';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Alpina\RecipesAndArticles\Model\ResourceModel\Recipe::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get Recipe ID
     *
     * @return int
     */
    public function getRecipeId()
    {
        return $this->getData('recipe_id');
    }

    /**
     * Get Title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getData('title');
    }

    /**
     * Get URL Key
     *
     * @return string
     */
    public function getUrlKey()
    {
        return $this->getData('url_key');
    }

    /**
     * Set Recipe ID
     *
     * @param int $recipeId
     * @return $this
     */
    public function setRecipeId($recipeId)
    {
        return $this->setData('recipe_id', $recipeId);
    }

    /**
     * Set Title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        return $this->setData('title', $title);
    }

    /**
     * Set URL Key
     *
     * @param string $urlKey
     * @return $this
     */
    public function setUrlKey($urlKey)
    {
        return $this->setData('url_key', $urlKey);
    }
}
