<?php

namespace Lima\OrderExporter\Ui\Component\QueueListing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Actions
 * @package Lima\OrderExporter\Ui\Component\QueueListing\Column
 */
class Actions extends Column
{
    const URL_PATH_VIEW = 'orderexporter/queue/view';

    const URL_PATH_DELETE = 'orderexporter/queue/delete';

    /**
     * @var UrlInterface
     */
    protected $_urlBuilder;

    /**
     * Actions constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    )
    {
        $this->_urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $item[$this->getData('name')] = [
                    'view' => [
                        'href' => $this->_urlBuilder->getUrl(
                                static::URL_PATH_VIEW,
                                [
                                    'export_id' => $item['export_id']
                                ]
                            ),
                        'label' => __('View')
                    ],
                    'remove' => [
                        'href' => $this->_urlBuilder->getUrl(
                                static::URL_PATH_DELETE,
                                [
                                    'export_id' => $item['export_id']
                                ]
                            ),
                        'label' => __('Remove')
                    ],
                ];
            }
        }
        return $dataSource;
    }
}
