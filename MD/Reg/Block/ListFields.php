<?php
namespace MD\Reg\Block;

Class ListFields extends \Magento\Framework\View\Element\Template
{
    protected $fieldsFactory;
    protected $helper;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \MD\Reg\Model\FieldsFactory $fieldsFactory,
        \MD\Reg\Helper\Data $helper
    ){
        parent::__construct($context);
        $this->fieldsFactory = $fieldsFactory;
        $this->helper = $helper;
    }

    public function getBaseUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl();
    }

    public function getListFields()
    {
        $collection = $this->fieldsFactory->create()->getCollection();
        $collection->addFieldToFilter('status',1);

        return $collection;
    }

    public function getConfigStatus() {
        return $this->helper->getGeneralConfig('enable');
    }

}

