<?php

namespace Lima\OrderExporter\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Lima\OrderExporter\Api\Data\QueueInterface;

/**
 * Interface QueueRepositoryInterface
 * @package Lima\OrderExporter\Api
 */
interface QueueRepositoryInterface
{
    /**
     * @param $id
     * @return mixed
     */
    public function getById($id);

    /**
     * @param QueueInterface $queue
     * @return mixed
     */
    public function save(QueueInterface $queue);

    /**
     * @param QueueInterface $queue
     * @return mixed
     */
    public function delete(QueueInterface $queue);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param QueueInterface $queue
     * @return mixed
     */
    public function exportItem(QueueInterface $queue);
}
