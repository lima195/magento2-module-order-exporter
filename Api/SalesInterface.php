<?php
namespace Lima\OrderExporter\Api;

/**
 * Interface SalesInterface
 * @package Lima\OrderExporter\Api
 */
interface SalesInterface
{
    /**
     * @param mixed $orderData
     * @return mixed
     */
	public function processOrder($orderData);
}
