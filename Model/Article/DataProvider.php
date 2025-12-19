<?php
/**
 * Copyright (c) Alpina. All rights reserved.
 */

namespace Alpina\RecipesAndArticles\Model\Article;

use Alpina\RecipesAndArticles\Model\ResourceModel\Article\CollectionFactory;
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
        CollectionFactory $articleCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $articleCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        foreach ($items as $article) {
            $this->loadedData[$article->getId()] = $article->getData();
        }

        $data = $this->dataPersistor->get('alpina_article');
        if (!empty($data)) {
            $article = $this->collection->getNewEmptyItem();
            $article->setData($data);
            $this->loadedData[$article->getId()] = $article->getData();
            $this->dataPersistor->clear('alpina_article');
        }

        return $this->loadedData;
    }
}
