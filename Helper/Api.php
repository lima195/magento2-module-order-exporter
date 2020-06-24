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
     * @param string $endpoint
     * @return string
     */
    public function buildUrl(string $endpoint)
    {
        return $this->getApiUrl() . $endpoint;
    }

    public function getBearerAuth()
    {
        $token = $this->getApiKey();
        return "Bearer {$token}";
    }
}
