<?php
namespace Lima\OrderExporter\Helper;

use Lima\OrderExporter\Helper\AbstractData;
use Lima\OrderExporter\Api\Data\QueueInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Api
 * @package Lima\OrderExporter\Helper
 */
class Api extends AbstractData
{
    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Api constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    ) {
        parent::__construct($scopeConfig);

        $this->_storeManager = $storeManager;
    }

    /**
     * @param string $endpoint
     * @return string
     */
    public function buildUrl(string $endpoint)
    {
        if($this->getIsTest()) {
            return $this->_storeManager->getStore()->getBaseUrl() . 'rest/default/V1' . $endpoint;
        }
        return $this->getApiUrl() . $endpoint;
    }

    public function getBearerAuth()
    {
        $token = $this->getApiKey();
        return "Bearer {$token}";
    }
}
