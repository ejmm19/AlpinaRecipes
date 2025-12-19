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

        // LOGGING: Capturar todos los datos que llegan
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/alpina_recipe_debug.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info('=== SAVE CONTROLLER CALLED ===');
        $logger->info('Raw POST data: ' . print_r($data, true));
        $logger->info('Request params: ' . print_r($this->getRequest()->getParams(), true));

        if ($data) {
            // Si los datos vienen dentro de 'data', extraerlos
            if (isset($data['data']) && is_array($data['data'])) {
                $logger->info('Extracting data from nested array');
                $data = $data['data'];
                $logger->info('Extracted data: ' . print_r($data, true));
            }
            
            $id = $this->getRequest()->getParam('recipe_id');
            $logger->info('Recipe ID from param: ' . ($id ?? 'NULL'));
            
            $model = $this->recipeFactory->create();

            if ($id) {
                $model->load($id);
                if (!$model->getId()) {
                    $this->messageManager->addErrorMessage(__('This recipe no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            if (empty($data['url_key']) && !empty($data['title'])) {
                $data['url_key'] = $this->generateUrlKey($data['title']);
                $logger->info('Generated URL key: ' . $data['url_key']);
            }

            $logger->info('Setting data to model: ' . print_r($data, true));
            $model->setData($data);

            try {
                $logger->info('Attempting to save...');
                $model->save();
                $logger->info('Save successful! Recipe ID: ' . $model->getId());
                $this->messageManager->addSuccessMessage(__('You saved the recipe.'));
                $this->dataPersistor->clear('alpina_recipe');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['recipe_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $logger->info('LocalizedException: ' . $e->getMessage());
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $logger->info('Exception: ' . $e->getMessage());
                $logger->info('Trace: ' . $e->getTraceAsString());
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the recipe.'));
            }

            $this->dataPersistor->set('alpina_recipe', $data);
            return $resultRedirect->setPath('*/*/edit', ['recipe_id' => $id]);
        } else {
            $logger->info('NO DATA RECEIVED IN POST!');
        }

        return $resultRedirect->setPath('*/*/');
    }

    protected function generateUrlKey($title)
    {
        $urlKey = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));
        return $urlKey;
    }
}
