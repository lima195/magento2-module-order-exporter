<?php

namespace Lima\OrderExporter\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface QueueSearchResultsInterface
 * @package Lima\OrderExporter\Api\Data
 */
interface QueueSearchResultsInterface extends SearchResultsInterface
{

    public function getItems();

    /**
     * @param array $items
     * @return QueueSearchResultsInterface
     */
    public function setItems(array $items);
}

