<?php

namespace Lima\OrderExporter\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface IbgeCityCodeSearchResultsInterface
 * @package Lima\OrderExporter\Api\Data
 */
interface IbgeCityCodeSearchResultsInterface extends SearchResultsInterface
{

    public function getItems();

    /**
     * @param array $items
     * @return IbgeCityCodeSearchResultsInterface
     */
    public function setItems(array $items);
}

