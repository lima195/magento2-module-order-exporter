<?php

namespace Lima\OrderExporter\Model;

use Magento\Framework\Model\AbstractModel;
use Lima\OrderExporter\Api\Data\IbgeCityCodeInterface;

/**
 * Class IbgeCityCode
 * @package Lima\OrderExporter\Model
 */
class IbgeCityCode extends AbstractModel implements IbgeCityCodeInterface
{
	protected function _construct()
	{
		$this->_init('Lima\OrderExporter\Model\ResourceModel\IbgeCityCode');
	}

    /**
     * @return int|mixed
     */
    public function getEntityId()
    {
        return (int) $this->getData('entity_id');
    }

    /**
     * @param int $entityId
     * @return IbgeCityCode|mixed
     */
    public function setEntityId($entityId)
    {
        return $this->setData('entity_id', $entityId);
    }

    /**
     * @return array|mixed|null
     */
    public function getUf()
    {
        return $this->getData('uf');
    }

    /**
     * @param $uf
     * @return IbgeCityCode|mixed
     */
    public function setUf($uf)
    {
        return $this->setData('uf'. $uf);
    }

    /**
     * @return array|mixed|null
     */
    public function getUfName()
    {
        return $this->getData('uf_name');
    }

    /**
     * @param $ufName
     * @return IbgeCityCode|mixed
     */
    public function setUfName($ufName)
    {
        return $this->setData('uf_name'. $ufName);
    }

    /**
     * @return array|mixed|null
     */
    public function getCityCode()
    {
        return $this->getData('city_code');
    }

    /**
     * @param $cityCode
     * @return IbgeCityCode|mixed
     */
    public function setCityCode($cityCode)
    {
        return $this->setData('city_code'. $cityCode);
    }

    /**
     * @return array|mixed|null
     */
    public function getCityCodeComplete()
    {
        return $this->getData('city_code_complete');
    }

    /**
     * @param $cityCodeComplete
     * @return IbgeCityCode|mixed
     */
    public function setCityCodeComplete($cityCodeComplete)
    {
        return $this->setData('city_code_complete'. $cityCodeComplete);
    }

    /**
     * @return array|mixed|null
     */
    public function getCityName()
    {
        return $this->getData('city_name');
    }

    /**
     * @param $cityName
     * @return IbgeCityCode|mixed
     */
    public function setCityName($cityName)
    {
        return $this->setData('city_name'. cityName);
    }

}
