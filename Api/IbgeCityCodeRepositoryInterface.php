<?php

namespace Lima\OrderExporter\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Lima\OrderExporter\Api\Data\IbgeCityCodeInterface;

/**
 * Interface IbgeCityCodeRepositoryInterface
 * @package Lima\OrderExporter\Api
 */
interface IbgeCityCodeRepositoryInterface
{
    /**
     * @param $id
     * @return mixed
     */
    public function getById($id);

    /**
     * @param IbgeCityCodeInterface $ibgeCityCode
     * @return mixed
     */
    public function save(IbgeCityCodeInterface $ibgeCityCode);

    /**
     * @param IbgeCityCodeInterface $ibgeCityCode
     * @return mixed
     */
    public function delete(IbgeCityCodeInterface $ibgeCityCode);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
