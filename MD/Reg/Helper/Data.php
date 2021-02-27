<?php
namespace MD\Reg\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const XML_PATH_MD_REG = 'md_reg/';

    public function getConfigValue($field, $storeCode = null)
    {
        return $this->scopeConfig->getValue($field, ScopeInterface::SCOPE_STORE, $storeCode);
    }

    public function getGeneralConfig($fieldid, $storeCode = null)
    {
        return $this->getConfigValue(self::XML_PATH_MD_REG.'general/'.$fieldid, $storeCode);
    }

}
