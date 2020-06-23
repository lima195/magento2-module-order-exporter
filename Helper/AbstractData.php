<?php
namespace Lima\OrderExporter\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;
use \Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class AbstractData
 * @package Lima\OrderExporter\Helper
 */
class AbstractData extends AbstractHelper
{
	const CONFIG_SECTION_ID = 'order_exporter';
	const CONFIG_GENERAL_GROUP = 'general';

    /**
     * @var ScopeConfigInterface
     */
	protected $_scopeConfig;

    /**
     * AbstractData constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
	public function __construct(
		ScopeConfigInterface $scopeConfig
	)
	{
		$this->_scopeConfig = $scopeConfig;
	}

    /**
     * @param string $group
     * @param string $config
     * @return mixed
     */
	public function getConfig(string $group, string $config)
	{
		$configPath = $this->_getConfigPath($group, $config);
		return $this->_scopeConfig->getValue($configPath);
	}

    /**
     * @param string $group
     * @param string $config
     * @return string
     */
	private function _getConfigPath(string $group, string $config)
	{
		$configPathArr = [self::CONFIG_SECTION_ID, $group, $config];
		return implode('/', $configPathArr);
	}

    /**
     * @return bool
     */
	public function isEnable()
	{
		return (bool) $this->getConfig(self::CONFIG_GENERAL_GROUP, 'enable');
	}

    /**
     * @return string
     */
	public function getApiKey()
	{
		return (string) $this->getConfig(self::CONFIG_GENERAL_GROUP, 'api_key');
	}

    /**
     * @return string
     */
	public function getApiUrl()
    {
		return (string) $this->getConfig(self::CONFIG_GENERAL_GROUP, 'api_url');
    }
}
