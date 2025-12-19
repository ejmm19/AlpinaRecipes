<?php
/**
 * Copyright (c) Alpina. All rights reserved.
 */

namespace Alpina\RecipesAndArticles\Controller\Adminhtml\Recipe;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Alpina\RecipesAndArticles\Model\RecipeFactory;

class Delete extends Action
{
    protected $recipeFactory;

    public function __construct(
        Context $context,
        RecipeFactory $recipeFactory
    ) {
        parent::__construct($context);
        $this->recipeFactory = $recipeFactory;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Alpina_RecipesAndArticles::recipes');
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('recipe_id');

        if ($id) {
            try {
                $model = $this->recipeFactory->create();
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccessMessage(__('The recipe has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['recipe_id' => $id]);
            }
        }

        $this->messageManager->addErrorMessage(__('We can\'t find a recipe to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
