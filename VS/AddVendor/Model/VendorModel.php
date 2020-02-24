<?php

namespace VS\AddVendor\Model;

use Magento\Framework\Model\AbstractModel;

class VendorModel extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('VS\AddVendor\Model\ResourceModel\VendorResourceModel');
    }


    public function getIcon()
    {
        return $this->getData('icon');
    }

    public function getDescription()
    {
        return $this->getData('description');
    }

    public function getName()
    {
        return $this->getData('name');
    }


    public function setIcon($icon)
    {
        return $this->setData('icon', $icon);
    }

}