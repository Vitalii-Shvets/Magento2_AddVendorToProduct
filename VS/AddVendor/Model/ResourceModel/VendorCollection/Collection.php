<?php

namespace VS\AddVendor\Model\ResourceModel\VendorCollection;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(			'VS\AddVendor\Model\VendorModel',
            'VS\AddVendor\Model\ResourceModel\VendorResourceModel');
    }
}