<?php


namespace VS\AddVendor\Plugin;

class ProductList
{
    protected $layout;

    public function __construct(
        \Magento\Framework\View\LayoutInterface $layout
    )
    {
        $this->layout = $layout;
    }

    public function aroundGetProductDetailsHtml(
        \Magento\Catalog\Block\Product\ListProduct $subject,
        \Closure $proceed,
        \Magento\Catalog\Model\Product $product
    )
    {
        return $this->layout->createBlock('VS\AddVendor\Block\IndexVendor')->setProduct($product)->setTemplate('VS_AddVendor::list.phtml')->toHtml();
    }
}