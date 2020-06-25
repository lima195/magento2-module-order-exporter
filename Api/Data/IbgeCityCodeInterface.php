<?php

namespace Lima\OrderExporter\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface IbgeCityCodeInterface
 * @package Lima\OrderExporter\Api\Data
 */
interface IbgeCityCodeInterface extends ExtensibleDataInterface
{
    /**
     * @return mixed
     */
    public function getEntityId();

    /**
     * @param $entityId
     * @return mixed
     */
    public function setEntityId($entityId);

    /**
     * @return mixed
     */
    public function getUf();

    /**
     * @param $uf
     * @return mixed
     */
    public function setUf($uf);

    /**
     * @return mixed
     */
    public function getUfName();

    /**
     * @param $ufName
     * @return mixed
     */
    public function setUfName($ufName);

    /**
     * @return mixed
     */
    public function getCityCode();

    /**
     * @param $cityCode
     * @return mixed
     */
    public function setCityCode($cityCode);

    /**
     * @return mixed
     */
    public function getCityCodeComplete();

    /**
     * @param $cityCodeComplete
     * @return mixed
     */
    public function setCityCodeComplete($cityCodeComplete);

    /**
     * @return mixed
     */
    public function getCityName();

    /**
     * @param $cityName
     * @return mixed
     */
    public function setCityName($cityName);
}
