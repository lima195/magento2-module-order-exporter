<?php

namespace Lima\OrderExporter\Model\ResourceModel\IbgeCityCode;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
	protected $_idFieldName = 'entity_id';

    /**
     * @var string
     */
	protected $_eventPrefix = 'ibge_city_code_collection';

    /**
     * @var string
     */
	protected $_eventObject = 'ibge_city_code_collection';

	protected function _construct()
	{
		$this->_init('Lima\OrderExporter\Model\IbgeCityCode', 'Lima\OrderExporter\Model\ResourceModel\IbgeCityCode');
	}
}
