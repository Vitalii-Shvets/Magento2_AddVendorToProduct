<?php

namespace VS\AddVendor\Block;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template\Context;
use VS\AddVendor\Model\ResourceModel\VendorCollection\CollectionFactory;
class IndexVendor extends Template{
    private $coreRegistry;
    public $collection;
    private $storeManager;
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        CollectionFactory $collectionFactory

    ) {
        $this->collection = $collectionFactory->create();
        $this->coreRegistry = $coreRegistry;
        $this->storeManager = $context->getStoreManager();
        parent::__construct($context);
    }


    public function getVendorsCategoryProduct() {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $product = $objectManager->get('Magento\Catalog\Model\Product')->load($this->getData('product')->getId());
        $mass_vendor_id = explode(',', $product->getCustomAttribute('vendor')->getValue());
        $this->collection->addFieldToFilter('status', 1);
        $this->collection->addFieldToFilter('vendor_id', ['in' => $mass_vendor_id]);
        return $this->collection;
    }
public function getVendors()
    {
        $product = $this->coreRegistry->registry('product');
        $mass_vendor_id = explode(',', $product->getCustomAttribute('vendor')->getValue());
        $this->collection->addFieldToFilter('status', 1);
        $this->collection->addFieldToFilter('vendor_id', ['in' => $mass_vendor_id]);
        return $this->collection;
    }

    public function getImageUrl($icon)
    {
        $mediaUrl = $this->storeManager
            ->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $imageUrl = $mediaUrl.'vs/tmp/icon/'.$icon;
        return $imageUrl;
    }
}