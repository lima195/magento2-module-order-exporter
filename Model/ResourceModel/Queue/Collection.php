<?php

namespace Lima\OrderExporter\Model\ResourceModel\Queue;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Lima\OrderExporter\Model\ResourceModel\Queue
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
	protected $_idFieldName = 'export_id';

    /**
     * @var string
     */
	protected $_eventPrefix = 'order_exporter_queue_collection';

    /**
     * @var string
     */
	protected $_eventObject = 'order_exporter_queue_collection';

	protected function _construct()
	{
		$this->_init('Lima\OrderExporter\Model\Queue', 'Lima\OrderExporter\Model\ResourceModel\Queue');
	}
}
