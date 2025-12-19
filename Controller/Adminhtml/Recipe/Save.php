<?php
/**
 * Copyright (c) Alpina. All rights reserved.
 */

namespace Alpina\RecipesAndArticles\Controller\Adminhtml\Recipe;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Alpina\RecipesAndArticles\Model\RecipeFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends Action
{
    protected $dataPersistor;
    protected $recipeFactory;

    public function __construct(
        Context $context,
        RecipeFactory $recipeFactory,
        DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context);
        $this->recipeFactory = $recipeFactory;
        $this->dataPersistor = $dataPersistor;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Alpina_RecipesAndArticles::recipes');
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $id = $this->getRequest()->getParam('recipe_id');
            $model = $this->recipeFactory->create();

            if ($id) {
                $model->load($id);
                if (!$model->getId()) {
                    $this->messageManager->addErrorMessage(__('This recipe no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            if (empty($data['url_key'])) {
                $data['url_key'] = $this->generateUrlKey($data['title']);
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the recipe.'));
                $this->dataPersistor->clear('alpina_recipe');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['recipe_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the recipe.'));
            }

            $this->dataPersistor->set('alpina_recipe', $data);
            return $resultRedirect->setPath('*/*/edit', ['recipe_id' => $id]);
        }

        return $resultRedirect->setPath('*/*/');
    }

    protected function generateUrlKey($title)
    {
        $urlKey = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));
        return $urlKey;
    }
}
