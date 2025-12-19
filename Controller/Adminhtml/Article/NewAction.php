<?php
/**
 * Copyright (c) Alpina. All rights reserved.
 */

namespace Alpina\ArticlesAndArticles\Controller\Adminhtml\Article;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class NewAction extends Action
{
    protected $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Alpina_ArticlesAndArticles::articles');
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Alpina_ArticlesAndArticles::articles');
        $resultPage->getConfig()->getTitle()->prepend(__('New Article'));
        return $resultPage;
    }
}
