<?php
/**
 * Copyright (c) Alpina. All rights reserved.
 */

namespace Alpina\RecipesAndArticles\Model\Recipe;

use Alpina\RecipesAndArticles\Model\ResourceModel\Recipe\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $collection;
    protected $dataPersistor;
    protected $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $recipeCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $recipeCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        foreach ($items as $recipe) {
            $this->loadedData[$recipe->getId()] = $recipe->getData();
        }

        $data = $this->dataPersistor->get('alpina_recipe');
        if (!empty($data)) {
            $recipe = $this->collection->getNewEmptyItem();
            $recipe->setData($data);
            $this->loadedData[$recipe->getId()] = $recipe->getData();
            $this->dataPersistor->clear('alpina_recipe');
        }

        return $this->loadedData;
    }
}
