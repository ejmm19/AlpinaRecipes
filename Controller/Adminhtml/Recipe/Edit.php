<?php
/**
 * Copyright (c) Alpina. All rights reserved.
 */

namespace Alpina\RecipesAndArticles\Controller\Adminhtml\Recipe;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;
use Alpina\RecipesAndArticles\Model\RecipeFactory;

class Edit extends Action
{
    protected $resultPageFactory;
    protected $coreRegistry;
    protected $recipeFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $coreRegistry,
        RecipeFactory $recipeFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $coreRegistry;
        $this->recipeFactory = $recipeFactory;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Alpina_RecipesAndArticles::recipes');
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('recipe_id');
        $model = $this->recipeFactory->create();

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This recipe no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->coreRegistry->register('alpina_recipe', $model);

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Alpina_RecipesAndArticles::recipes');
        $resultPage->getConfig()->getTitle()->prepend(
            $model->getId() ? __('Edit Recipe: %1', $model->getTitle()) : __('New Recipe')
        );

        return $resultPage;
    }
}
