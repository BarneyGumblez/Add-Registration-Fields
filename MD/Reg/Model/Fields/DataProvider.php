<?php
namespace MD\Reg\Model\Fields;

use MD\Reg\Model\ResourceModel\Fields\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \MD\Reg\Model\ResourceModel\Fields\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $fieldsCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $fieldsCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $fieldsCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->meta = $this->prepareMeta($this->meta);
    }

    /**
     * Prepares Meta
     *
     * @param array $meta
     * @return array
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var $fields \MD\Reg\Model\Fields */
        foreach ($items as $fields) {
            $this->loadedData[$fields->getId()] = $fields->getData();
            
            if($fields->getData()['options']) {
                $this->loadedData[$fields->getId()]['options'] = unserialize($fields->getData()['options']);
            }
        }

        $data = $this->dataPersistor->get('reg_fields');
        if (!empty($data)) {
            $fields = $this->collection->getNewEmptyItem();
            $fields->setData($data);
            $this->loadedData[$fields->getId()] = $fields->getData();
            $this->dataPersistor->clear('reg_fields');

        }
        return $this->loadedData;
    }
}
