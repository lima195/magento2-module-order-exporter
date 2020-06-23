<?php

namespace Lima\OrderExporter\Model;

use Magento\Framework\Model\AbstractModel;
use Lima\OrderExporter\Api\Data\QueueInterface;

/**
 * Class Queue
 * @package Lima\OrderExporter\Model
 */
class Queue extends AbstractModel implements QueueInterface
{
    /*
     * mixed
     */
    protected $_payload;

	protected function _construct()
	{
		$this->_init('Lima\OrderExporter\Model\ResourceModel\Queue');
	}

    /**
     * @return int|mixed
     */
    public function getExportId()
    {
        return (int) $this->getData('export_id');
    }

    /**
     * @param $importId
     * @return Queue|mixed
     */
    public function setExportId($importId)
    {
        return $this->setData('export_id', $importId);
    }

    /**
     * @return array|mixed|null
     */
    public function getOrderId()
    {
        return $this->getData('order_id');
    }

    /**
     * @param $orderId
     * @return Queue|mixed
     */
    public function setOrderId($orderId)
    {
         return $this->setData('order_id', $orderId);
    }

    /**
     * @return array|mixed|null
     */
    public function getPayload()
    {
        return $this->getData('payload');
    }

    /**
     * @param $payload
     * @return Queue|mixed
     */
    public function setPayload($payload)
    {
        return $this->setData('payload', $payload);
    }

    /**
     * @return array|mixed|null
     */
    public function getErrorLog()
    {
        return $this->getData('error_log');
    }

    /**
     * @param $errorLog
     * @return Queue|mixed
     */
    public function setErrorLog($errorLog)
    {
        return $this->setData('error_log', $errorLog);
    }

    /**
     * @return array|mixed|null
     */
    public function getCreatedAt()
    {
        return $this->getData('created_at');
    }

    /**
     * @param $createdAt
     * @return Queue|mixed
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData('created_at', $createdAt);
    }

    /**
     * @return array|mixed|null
     */
    public function getUpdatedAt()
    {
        return $this->getData('updated_at');
    }

    /**
     * @param $updatedAt
     * @return Queue|mixed
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData('update_at', $updatedAt);
    }

    /**
     * @return array|mixed|null
     */
    public function getPending()
    {
        return $this->getData('pending');
    }

    /**
     * @param $pending
     * @return Queue|mixed
     */
    public function setPending($pending)
    {
        return $this->setData('pending', $pending);
    }

}
