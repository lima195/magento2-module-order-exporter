<?php
namespace Lima\OrderExporter\Model;

use Magento\Framework\HTTP\Client\Curl;
use Lima\OrderExporter\Helper\AbstractData as Helper;

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
     * @param array $queue
     * @return mixed
     */
    public function export(array $queue)
    {
        die('ok');
        $url =  $this->_helper->buildCall($filter, self::ENDPOINT_EXPORT_ORDER);

        $this->_curl->get($url);

        $response = json_decode($this->_curl->getBody(), true);

        var_dump($response);
        die;

        return $response;
    }

}
