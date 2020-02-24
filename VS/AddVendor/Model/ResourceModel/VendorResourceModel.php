<?php

namespace VS\AddVendor\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class VendorResourceModel extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('vs_add_vendor_table', 'vendor_id');
    }
}