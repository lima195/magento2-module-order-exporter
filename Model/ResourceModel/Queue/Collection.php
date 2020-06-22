<?php

namespace Lima\OrderExporter\Model\ResourceModel\Queue;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
	protected $_idFieldName = 'export_id';

	protected $_eventPrefix = 'order_exporter_queue_collection';

	protected $_eventObject = 'order_exporter_queue_collection';

	protected function _construct()
	{
		$this->_init('Lima\OrderExporter\Model\Queue', 'Lima\OrderExporter\Model\ResourceModel\Queue');
	}

}
