<?php
namespace Lima\OrderExporter\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class IbgeCityCode
 * @package Lima\OrderExporter\Model\ResourceModel
 */
class IbgeCityCode extends AbstractDb
{
	protected function _construct()
	{
		$this->_init('ibge_city_code', 'entity_id');
	}
}
