<?php
//
//
//namespace VS\AddVendor\Controller\Adminhtml\Vendor;
//
//use Magento\Backend\App\Action;
//use Magento\Backend\App\Action\Context;
//use Magento\Framework\View\Result\PageFactory;
//use Magento\Framework\Registry;
//use VS\AddVendor\Model\VendorModel;
//
//class Edit extends Action
//{
//    protected $resultPageFactory;
//    protected $coreRegistry;
//    const ADMIN_RESOURCE = 'VS_AddVendor::vendor';
//
//    public function __construct(
//        Context $context,
//        Registry $coreRegistry,
//        PageFactory $resultPageFactory,
//        VendorModel $vendorModel
//    )
//    {
//        $this->coreRegistry = $coreRegistry;
//        $this->resultPageFactory = $resultPageFactory;
//        $this->vendorModel = $vendorModel;
//        parent::__construct($context, $coreRegistry);
//    }
//
//    public function execute()
//    {
//        $model = $this->_objectManager->create('VS\AddVendor\Model\VendorModel');
//
//        return $this->resultPageFactory->create();
//    }
//}


namespace VS\AddVendor\Controller\Adminhtml\Vendor;
use Magento\Framework\Registry;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use VS\AddVendor\Model\VendorModel;
class Edit extends Action
{

    private $resultPageFactory;
    private $vendorModel;
    private $coreRegistry;
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        VendorModel $vendorModel
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->vendorModel = $vendorModel;
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context, $coreRegistry);
    }

    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = $this->vendorModel;

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This vendor no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->coreRegistry->register('vs_addvendor', $model);

        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Vendors'));

        $resultPage->addBreadcrumb(__('Catalog'), __('Catalog'));
        $resultPage->addBreadcrumb(__('Vendor'), __('Vendor'));

        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getName() : __('New Vendor'));
        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('VS_AddVendor::vendor');
    }
}
