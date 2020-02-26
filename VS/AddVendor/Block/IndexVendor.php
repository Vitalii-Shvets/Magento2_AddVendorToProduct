<?php


namespace VS\AddVendor\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template\Context;
use VS\AddVendor\Model\ResourceModel\VendorCollection\CollectionFactory;

class IndexVendor extends Template
{
    private $coreRegistry;
    private $scopeConfig;
    public $collection;
    private $storeManager;

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        CollectionFactory $collectionFactory

    )
    {
        $this->scopeConfig = $context->getScopeConfig();
        $this->collection = $collectionFactory->create();
        $this->coreRegistry = $coreRegistry;
        $this->storeManager = $context->getStoreManager();
        parent::__construct($context);
    }

    public function getVendors()
    {
        $product = $this->coreRegistry->registry('product') ? $this->coreRegistry->registry('product') : $this->getData('product');
        $massVendorId = explode(',', $product->getCustomAttribute('vendor')->getValue());
        $this->collection->addFieldToFilter('status', 1);
        $this->collection->addFieldToFilter('vendor_id', ['in' => $massVendorId]);

        return $this->collection;
    }

    public function getImageUrl($icon)
    {
        $mediaUrl = $this->storeManager
            ->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $imageUrl = $mediaUrl . 'vs/tmp/icon/' . $icon;

        return $imageUrl;
    }

    public function isActive()
    {
        return $this->scopeConfig->getValue(
            'vendor/general/enable',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}