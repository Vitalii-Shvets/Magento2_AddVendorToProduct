<?php


namespace VS\AddVendor\Controller\Adminhtml\Vendor;

use \Magento\Backend\App\Action;

class Delete extends Action
{
    const ADMIN_RESOURCE = 'VS_AddVendor::vendor';

    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id && (int)$id > 0) {
            try {
                $model = $this->_objectManager->create('VS\AddVendor\Model\VendorModel');
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('The record has been deleted successfully.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());

                return $resultRedirect->setPath('*/*/index');
            }
        }
        $this->messageManager->addError(__('Record doesn\'t exist any longer.'));

        return $resultRedirect->setPath('*/*/index');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('VS_AddVendor::vendor');
    }
}