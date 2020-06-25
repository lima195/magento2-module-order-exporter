<?php
namespace Lima\OrderExporter\Model;

use Magento\Framework\HTTP\Client\Curl;
use Lima\OrderExporter\Helper\Api as Helper;
use Lima\OrderExporter\Api\Data\QueueInterface;

/**
 * Class Api
 * @package Lima\OrderExporter\Model
 */
class Api
{
    const ENDPOINT_EXPORT_ORDER = '/webhook/sales';
    const INTERNAL_API_KEY_ARRAY = 'order_data';

    /**
     * @var Curl
     */
    protected $_curl;

    /**
     * @var Helper
     */
    protected $_helper;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $_logger;

    /**
     * Api constructor.
     * @param Curl $curl
     * @param Helper $helper
     * @param \Psr\Log\LoggerInterface $logger
     */
	public function __construct(
        Curl $curl,
        Helper $helper,
        \Psr\Log\LoggerInterface $logger
    ) {
		$this->_curl = $curl;
        $this->_helper = $helper;
        $this->_logger = $logger;
    }

    /**
     * @param QueueInterface $queue
     * @return mixed
     */
    public function export(QueueInterface $queue)
    {
        $url =  $this->_helper->buildUrl(self::ENDPOINT_EXPORT_ORDER);
        $headers = ["Content-Type" => "application/json", "Authorization" => $this->_helper->getBearerAuth()];
        $this->_curl->setHeaders($headers);
        $payload = $queue->getPayload();

        if($this->_helper->getIsTest()) {
            $payloadArray = json_decode($payload);
            $payload = json_encode([self::INTERNAL_API_KEY_ARRAY => $payloadArray]);
        }

        try {
            $this->_curl->post($url, $payload);
        } catch (\Exception $e) {
            $this->_logger->critical('Error message', ['exception' => $e->getMessage()]);
        }

        $response = json_decode($this->_curl->getBody(), true);

        return $response;
    }

}
