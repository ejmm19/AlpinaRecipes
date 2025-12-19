<?php
/**
 * Copyright (c) Alpina. All rights reserved.
 */

namespace Alpina\ArticlesAndArticles\Block\Adminhtml\Article\Edit;

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
        $articleId = $this->context->getRequest()->getParam('article_id');
        
        if ($articleId) {
            $data = [
                'label' => __('Delete Article'),
                'class' => 'delete',
                'on_click' => sprintf("deleteConfirm('%s', '%s')", 
                    __('Are you sure you want to delete this article?'),
                    $this->getDeleteUrl()
                ),
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    public function getDeleteUrl()
    {
        $articleId = $this->context->getRequest()->getParam('article_id');
        return $this->context->getUrlBuilder()->getUrl('*/*/delete', ['article_id' => $articleId]);
    }
}
