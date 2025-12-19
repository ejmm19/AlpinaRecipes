<?php
/**
 * Copyright (c) Alpina. All rights reserved.
 */

namespace Alpina\ArticlesAndArticles\Controller\Adminhtml\Article;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;
use Alpina\ArticlesAndArticles\Model\ArticleFactory;

class Edit extends Action
{
    protected $resultPageFactory;
    protected $coreRegistry;
    protected $articleFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $coreRegistry,
        ArticleFactory $articleFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $coreRegistry;
        $this->articleFactory = $articleFactory;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Alpina_ArticlesAndArticles::articles');
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('article_id');
        $model = $this->articleFactory->create();

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This article no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->coreRegistry->register('alpina_article', $model);

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Alpina_ArticlesAndArticles::articles');
        $resultPage->getConfig()->getTitle()->prepend(
            $model->getId() ? __('Edit Article: %1', $model->getTitle()) : __('New Article')
        );

        return $resultPage;
    }
}
