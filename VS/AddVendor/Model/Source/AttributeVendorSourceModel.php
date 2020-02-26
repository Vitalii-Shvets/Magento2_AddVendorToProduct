<?php


namespace VS\AddVendor\Model\Source;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use VS\AddVendor\Model\ResourceModel\VendorCollection\CollectionFactory;

class AttributeVendorSourceModel extends AbstractSource
{
    public $collection;

    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collection = $collectionFactory->create();
    }

    public function getAllOptions()
    {
        $ret = [];

        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $ret[] = [
                'value' => $model->getId(),
                'label' => $model->getName()
            ];
        }
        return $ret;
    }

}