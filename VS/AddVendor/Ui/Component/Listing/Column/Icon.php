<?php


namespace VS\AddVendor\Ui\Component\Listing\Column;

use Magento\Framework\View\Asset\Repository;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;

class Icon extends \Magento\Ui\Component\Listing\Columns\Column
{
    private $storeManager;
    private $assetRepo;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        StoreManagerInterface $storeManager,
        Repository $assetRepo,
        array $components = [],
        array $data = []
    )
    {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->storeManager = $storeManager;
        $this->assetRepo = $assetRepo;
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $path = $this->storeManager->getStore()->getBaseUrl(
                    \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                ) . 'vs/tmp/icon/';

            $baseImage = $this->assetRepo->getUrl('VS_AddVendor::images/vs_addvendor.png');
            foreach ($dataSource['data']['items'] as & $item) {
                if ($item['icon']) {
                    $item['icon' . '_src'] = $path . $item['icon'];
                    $item['icon' . '_alt'] = $item['name'];
                    $item['icon' . '_orig_src'] = $path . $item['icon'];
                } else {
                    $item['icon' . '_src'] = $baseImage;
                    $item['icon' . '_alt'] = 'Vendor';
                    $item['icon' . '_orig_src'] = $baseImage;
                }
            }
        }

        return $dataSource;
    }
}
