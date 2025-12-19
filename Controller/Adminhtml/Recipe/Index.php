<?php
/**
 * Copyright © Alpina. All rights reserved.
 */

namespace Alpina\RecipesAndArticles\Controller\Adminhtml\Recipe;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Check for is allowed
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Alpina_RecipesAndArticles::recipes');
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Alpina_RecipesAndArticles::recipes');
        $resultPage->getConfig()->getTitle()->prepend(__('Recipes Management'));
        return $resultPage;
    }
}
