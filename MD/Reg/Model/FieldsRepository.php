<?php

namespace MD\Reg\Model;

use MD\Reg\Api\Data;
use MD\Reg\Api\FieldsRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use MD\Reg\Model\ResourceModel\Fields as ResourceFields;
use MD\Reg\Model\ResourceModel\Fields\CollectionFactory as FieldsCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class FieldsRepository implements FieldsRepositoryInterface
{
    protected $resource;

    protected $fieldsFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $dataFieldsFactory;

    private $storeManager;

    public function __construct(
        ResourceFields $resource,
        FieldsFactory $fieldsFactory,
        Data\FieldsInterfaceFactory $dataFieldsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->fieldsFactory = $fieldsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataFieldsFactory = $dataFieldsFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    public function save(\MD\Reg\Api\Data\FieldsInterface $fields)
    {
        if ($fields->getStoreId() === null) {
            $storeId = $this->storeManager->getStore()->getId();
            $fields->setStoreId($storeId);
        }
        try {
            $this->resource->save($fields);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the news: %1', $exception->getMessage()),
                $exception
            );
        }
        return $fields;
    }

    public function getById($fieldId)
    {
        $fields = $this->fieldsFactory->create();
        $fields->load($fieldId);
        if (!$fields->getId()) {
            throw new NoSuchEntityException(__('News with id "%1" does not exist.', $fieldId));
        }
        return $fields;
    }

    public function delete(\MD\Reg\Api\Data\FieldsInterface $fields)
    {
        try {
            $this->resource->delete($fields);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the field: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    public function deleteById($fieldId)
    {
        return $this->delete($this->getById($fieldId));
    }
}
?>
