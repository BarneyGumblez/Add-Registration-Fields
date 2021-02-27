<?php

namespace MD\Reg\Controller\Adminhtml\Fields;

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
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
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Fields
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Fields $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('MD_Reg::reg_fields')
            ->addBreadcrumb(__('Fields'), __('Fields'))
            ->addBreadcrumb(__('Manage Fields'), __('Manage Fields'));
        return $resultPage;
    }

    /**
     * Edit Allnews
     *
     * @return \Magento\Backend\Model\View\Result\Fields|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('field_id');
        $model = $this->_objectManager->create(\MD\Reg\Model\Fields::class);


        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This field no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('reg_fields', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Fields $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Fields') : __('Add Fields'),
            $id ? __('Edit Fields') : __('Add Fields')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Fields'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('Add Fields'));

        return $resultPage;
    }
}

