<?php


namespace VS\AddVendor\Controller\Adminhtml\Vendor;

use Magento\Framework\Exception\LocalizedException;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use VS\AddVendor\Model\VendorModel;
use Magento\Backend\App\Action;

class Save extends Action
{

    private $dataPersistor;
    private $vendorModel;
    const ADMIN_RESOURCE = 'VS_AddVendor::vendor';
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        VendorModel $vendorModel
    )
    {
        $this->dataPersistor = $dataPersistor;
        $this->vendorModel = $vendorModel;
        parent::__construct($context);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('VS_AddVendor::vendor');
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('vendor_id');

            $model = $this->vendorModel->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Vendor no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
            $data = $this->_filterVendorGroupData($data);
            $model->setData($data);
            try {

                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Vendor.'));
                $this->dataPersistor->clear('vs_addvendor');
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Vendor.'));
            }

            $this->dataPersistor->set('vs_addvendor', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('vendor_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    public function _filterVendorGroupData(array $rawData)
    {
        $data = $rawData;
        if (isset($data['icon'][0]['name'])) {
            $data['icon'] = $data['icon'][0]['name'];
        } else {
            $data['icon'] = null;
        }
        return $data;
    }
}