<?php

namespace Lima\OrderExporter\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface QueueInterface
 * @package Lima\OrderExporter\Api\Data
 */
interface QueueInterface extends ExtensibleDataInterface
{
    /**
     * @return mixed
     */
    public function getExportId();

    /**
     * @param $exportId
     * @return mixed
     */
    public function setExportId($exportId);

    /**
     * @return mixed
     */
    public function getOrderId();

    /**
     * @param $orderId
     * @return mixed
     */
    public function setOrderId($orderId);

    /**
     * @return mixed
     */
    public function getPayload();

    /**
     * @param $payload
     * @return mixed
     */
    public function setPayload($payload);

    /**
     * @return mixed
     */
    public function getErrorLog();

    /**
     * @param $errorLog
     * @return mixed
     */
    public function setErrorLog($errorLog);

    /**
     * @return mixed
     */
    public function getCreatedAt();

    /**
     * @param $createdAt
     * @return mixed
     */
    public function setCreatedAt($createdAt);

    /**
     * @return mixed
     */
    public function getUpdatedAt();

    /**
     * @param $updatedAt
     * @return mixed
     */
    public function setUpdatedAt($updatedAt);

    /**
     * @return mixed
     */
    public function getPending();

    /**
     * @param $pending
     * @return mixed
     */
    public function setPending($pending);
}
