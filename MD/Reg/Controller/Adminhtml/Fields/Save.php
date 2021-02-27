<?php

namespace MD\Reg\Controller\Adminhtml\Fields;

use Magento\Backend\App\Action;
use MD\Reg\Model\Fields;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var \MD\Reg\Model\FieldsFactory
     */
    private $fieldsFactory;

    /**
     * @var \MD\Reg\Api\FieldsRepositoryInterface
     */
    private $fieldsRepository;

    /**
     * @param Action\Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param \MD\Reg\Model\FieldsFactory $fieldsFactory,
     * @param \MD\Reg\Api\FieldsRepositoryInterface $fieldsReposity
     */
    public function __construct(
        Action\Context $context,
        DataPersistorInterface $dataPersistor,
        \MD\Reg\Model\FieldsFactory $fieldsFactory = null,
        \MD\Reg\Api\FieldsRepositoryInterface $fieldsRepository = null
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->fieldsFactory = $fieldsFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\MD\Reg\Model\FieldsFactory::class);
        $this->fieldsRepository = $fieldsRepository
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\MD\Reg\Api\FieldsRepositoryInterface::class);
        parent::__construct($context);
    }

    /**
     * Authorization level
     *
     * @see _isAllowed()
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('MD_Reg::save');
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            if (isset($data['status']) && $data['status'] === 'true') {
                $data['status'] = Fields::STATUS_ENABLED;
            }
            if (empty($data['field_id'])) {
                $data['field_id'] = null;
            }

            if(isset($data['options'])) {
                $i = 0;
                foreach ($data['options'] as $option){
                    if(strlen($option['name_option']) == 0) {
                        unset($data['options'][$i]);
                    }
                    $i++;
                }
                $data['options'] = serialize($data['options']);
            } else {
                $data['options'] = null;
            }
            /** @var \MD\Reg\Model\Fields $model */
            $model = $this->fieldsFactory->create();

            $id = $this->getRequest()->getParam('field_id');
            if ($id) {
                try {
                    $model = $this->fieldsRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This field no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            $this->_eventManager->dispatch(
                'reg_fields_prepare_save',
                ['fields' => $model, 'request' => $this->getRequest()]
            );

            try {
                $this->fieldsRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the field.'));
                $this->dataPersistor->clear('reg_fields');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['field_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?:$e);
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the field.'));
            }

            $this->dataPersistor->set('reg_field', $data);
            return $resultRedirect->setPath('*/*/edit', ['field_id' => $this->getRequest()->getParam('field_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}

