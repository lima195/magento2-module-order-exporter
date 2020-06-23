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
    const ENDPOINT_EXPORT_ORDER = 'order';

    /**
     * @var Curl
     */
    protected $_curl;

    /**
     * @var Helper
     */
    protected $_helper;

    /**
     * Api constructor.
     * @param Curl $curl
     * @param Helper $helper
     */
	public function __construct(
        Curl $curl,
        Helper $helper
    ) {
		$this->_curl = $curl;
        $this->_helper = $helper;
    }

    /**
     * @param QueueInterface $queue
     * @return mixed
     */
    public function export(QueueInterface $queue)
    {
        $url =  $this->_helper->buildUrl($queue, self::ENDPOINT_EXPORT_ORDER);

        $this->_curl->get($url);

        $response = json_decode($this->_curl->getBody(), true);

        return $response;
    }

}
