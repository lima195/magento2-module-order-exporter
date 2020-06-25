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
	const CONFIG_ATTRIBUTEMAPPER_GROUP = 'attribute_mapper';
	const CONFIG_APIFIELDSCONFIG_GROUP = 'api_fields_config';

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

    /**
     * @return string
     */
    public function getTypeCpf()
    {
        return (string) $this->getConfig(self::CONFIG_ATTRIBUTEMAPPER_GROUP, 'type_cpf');
    }

    /**
     * @return string
     */
    public function getCpfByAddress()
    {
        return (string) $this->getConfig(self::CONFIG_ATTRIBUTEMAPPER_GROUP, 'cpf_by_address');
    }

    /**
     * @return string
     */
    public function getCpfByCustomer()
    {
        return (string) $this->getConfig(self::CONFIG_ATTRIBUTEMAPPER_GROUP, 'cpf_by_customer');
    }

    /**
     * @return string
     */
    public function getTypeCnpj()
    {
        return (string) $this->getConfig(self::CONFIG_ATTRIBUTEMAPPER_GROUP, 'type_cnpj');
    }

    /**
     * @return string
     */
    public function getCnpjByAddress()
    {
        return (string) $this->getConfig(self::CONFIG_ATTRIBUTEMAPPER_GROUP, 'cnpj_by_address');
    }

    /**
     * @return string
     */
    public function getCnpjByCustomer()
    {
        return (string) $this->getConfig(self::CONFIG_ATTRIBUTEMAPPER_GROUP, 'cnpj_by_customer');
    }

    /**
     * @return string
     */
    public function getTypeNameCompany()
    {
        return (string) $this->getConfig(self::CONFIG_ATTRIBUTEMAPPER_GROUP, 'type_name_company');
    }

    /**
     * @return string
     */
    public function getCompanyNameAddress()
    {
        return (string) $this->getConfig(self::CONFIG_ATTRIBUTEMAPPER_GROUP, 'company_name_address');
    }

    /**
     * @return string
     */
    public function getCompanyNameCustomer()
    {
        return (string) $this->getConfig(self::CONFIG_ATTRIBUTEMAPPER_GROUP, 'company_name_customer');
    }

    /**
     * @return string
     */
    public function getStreetLogradouro()
    {
        return (string) $this->getConfig(self::CONFIG_ATTRIBUTEMAPPER_GROUP, 'street_logradouro');
    }

    /**
     * @return string
     */
    public function getStreetNumber()
    {
        return (string) $this->getConfig(self::CONFIG_ATTRIBUTEMAPPER_GROUP, 'street_number');
    }

    /**
     * @return string
     */
    public function getStreetComplement()
    {
        return (string) $this->getConfig(self::CONFIG_ATTRIBUTEMAPPER_GROUP, 'street_complement');
    }

    /**
     * @return string
     */
    public function getStreetDistrict()
    {
        return (string) $this->getConfig(self::CONFIG_ATTRIBUTEMAPPER_GROUP, 'street_district');
    }

    /**
     * @return string
     */
    public function getCpfAttribute()
    {
        $value = '';
        switch ($this->getTypeCpf()){
            case 'customer':
                $value = $this->getCpfByCustomer();
                break;
            case 'address':
                $value = $this->getCpfByAddress();
                break;
        }
        return (string) $value;
    }

    /**
     * @return string
     */
    public function getCnpjAttribute()
    {
        $value = '';
        switch ($this->getTypeCnpj()){
            case 'use_cpf':
                $value = $this->getCpfAttribute();
                break;
            case 'use_customer':
                $value = $this->getCnpjByCustomer();
                break;
            case 'use_address':
                $value = $this->getCnpjByAddress();
                break;
        }
        return (string) $value;
    }

    /**
     * @return bool
     */
    public function getIsTest()
    {
        return (bool) $this->getConfig(self::CONFIG_GENERAL_GROUP, 'internal_api_test');
    }

    /**
     * @return bool
     */
    public function getDateFormat()
    {
        return (string) $this->getConfig(self::CONFIG_APIFIELDSCONFIG_GROUP, 'date_format');
    }

    /**
     * @return bool
     */
    public function getIsIbgeCodeEnabled()
    {
        return (bool) $this->getConfig(self::CONFIG_APIFIELDSCONFIG_GROUP, 'send_ibge_city_code');
    }

    /**
     * @return bool
     */
    public function getUseIbgeCityCodeComplete()
    {
        return (bool) $this->getConfig(self::CONFIG_APIFIELDSCONFIG_GROUP, 'use_ibge_city_code_complete');
    }
}
