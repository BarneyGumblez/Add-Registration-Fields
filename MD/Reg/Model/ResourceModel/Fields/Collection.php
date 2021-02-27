<?php
namespace MD\Reg\Model\ResourceModel\Fields;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'field_id';

    protected $_eventPrefix = 'md_reg_collection';

    protected $_eventObject = 'fields_collection';

    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init('MD\Reg\Model\Fields', 'MD\Reg\Model\ResourceModel\Fields');
    }
}

