<?php
/**
 * Copyright (c) Alpina. All rights reserved.
 */

namespace Alpina\RecipesAndArticles\Block\Adminhtml\Recipe\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Backend\Block\Widget\Context;

class DeleteButton implements ButtonProviderInterface
{
    protected $context;

    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    public function getButtonData()
    {
        $data = [];
        $recipeId = $this->context->getRequest()->getParam('recipe_id');
        
        if ($recipeId) {
            $data = [
                'label' => __('Delete Recipe'),
                'class' => 'delete',
                'on_click' => sprintf("deleteConfirm('%s', '%s')", 
                    __('Are you sure you want to delete this recipe?'),
                    $this->getDeleteUrl()
                ),
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    public function getDeleteUrl()
    {
        $recipeId = $this->context->getRequest()->getParam('recipe_id');
        return $this->context->getUrlBuilder()->getUrl('*/*/delete', ['recipe_id' => $recipeId]);
    }
}
