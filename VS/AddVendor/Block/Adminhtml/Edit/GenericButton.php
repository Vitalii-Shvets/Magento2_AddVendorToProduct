<?php


namespace VS\AddVendor\Block\Adminhtml\Edit;

use Magento\Backend\Block\Widget\Context;

abstract class GenericButton
{

    private $context;

    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    public function getModelId()
    {
        return $this->context->getRequest()->getParam('vendor_id');
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
