<?php
namespace MD\Reg\Block\Adminhtml\Fields\Edit;

use Magento\Backend\Block\Widget\Context;
use MD\Reg\Api\FieldsRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    protected $context;

    protected $fieldsRepository;

    protected $eventManager;

    public function __construct(
        Context $context,
        FieldsRepositoryInterface $fieldsRepository,
        \Magento\Framework\Event\Manager $eventManager
    ) {
        $this->context = $context;
        $this->fieldsRepository = $fieldsRepository;
        $this->eventManager = $eventManager;
    }

    public function getFieldId()
    {
        try {
            return $this->fieldsRepository->getById(
                $this->context->getRequest()->getParam('field_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}

