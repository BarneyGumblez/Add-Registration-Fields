<?php
namespace MD\Reg\Block\Adminhtml;

class Fields extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_fields';
        $this->_blockGroup = 'MD_Reg';
        $this->_headerText = __('Manage Registration Fields');

        parent::_construct();

        if ($this->_isAllowedAction('MD_Reg::save')) {
            $this->buttonList->update('add', 'label', __('Add Field'));
        } else {
            $this->buttonList->remove('add');
        }
    }

    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
