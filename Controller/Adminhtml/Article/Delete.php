<?php
/**
 * Copyright (c) Alpina. All rights reserved.
 */

namespace Alpina\ArticlesAndArticles\Controller\Adminhtml\Article;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Alpina\ArticlesAndArticles\Model\ArticleFactory;

class Delete extends Action
{
    protected $articleFactory;

    public function __construct(
        Context $context,
        ArticleFactory $articleFactory
    ) {
        parent::__construct($context);
        $this->articleFactory = $articleFactory;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Alpina_ArticlesAndArticles::articles');
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('article_id');

        if ($id) {
            try {
                $model = $this->articleFactory->create();
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccessMessage(__('The article has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['article_id' => $id]);
            }
        }

        $this->messageManager->addErrorMessage(__('We can\'t find a article to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
