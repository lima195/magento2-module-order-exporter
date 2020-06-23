<?php
namespace Lima\OrderExporter\Helper;

use Lima\OrderExporter\Helper\AbstractData;
use Lima\OrderExporter\Api\Data\QueueInterface;

/**
 * Class Api
 * @package Lima\OrderExporter\Helper
 */
class Api extends AbstractData
{
    /**
     * @param QueueInterface $queue
     * @param string $endpoint
     * @return string
     */
    public function buildUrl(QueueInterface $queue, string $endpoint)
    {
        $url = $this->getApiUrl() . '/' . $endpoint;

        return $url;
    }
}
