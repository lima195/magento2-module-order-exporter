<?php

namespace Lima\OrderExporter\Model;

use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;
use Lima\OrderExporter\Api\Data\QueueSearchResultsInterfaceFactory;
use Lima\OrderExporter\Api\QueueRepositoryInterface;
use Lima\OrderExporter\Model\ResourceModel\Queue as QueueResource;
use Lima\OrderExporter\Model\ResourceModel\Queue\CollectionFactory;
use Lima\OrderExporter\Model\Api;
use Magento\Framework\Stdlib\DateTime\DateTime;
use \Psr\Log\LoggerInterface;

/**
 * Class QueueRepository
 * @package Lima\OrderExporter\Model
 */
class QueueRepository implements QueueRepositoryInterface
{
    /**
     * @var QueueResource
     */
    private $queueResource;

    /**
     * @var QueueFactory
     */
    private $queueFactory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var QueueSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var \Lima\OrderExporter\Model\Api
     */
    private $api;

    /**
     * @var DateTime
     */
    protected $coreDate;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * QueueRepository constructor.
     * @param QueueResource $queueResource
     * @param QueueFactory $queueFactory
     * @param CollectionFactory $collectionFactory
     * @param QueueSearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        QueueResource $queueResource,
        QueueFactory $queueFactory,
        CollectionFactory $collectionFactory,
        QueueSearchResultsInterfaceFactory $searchResultsFactory,
        Api $api,
        DateTime $coreDate,
        LoggerInterface $logger
    ) {
        $this->queueResource = $queueResource;
        $this->queueFactory = $queueFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->api = $api;
        $this->coreDate = $coreDate;
        $this->logger = $logger;
    }

    /**
     * @param \Lima\OrderExporter\Api\Data\QueueInterface $queue
     * @return mixed
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(\Lima\OrderExporter\Api\Data\QueueInterface $queue)
    {
        $this->queueResource->save($queue);
        return $queue->getExportId();
    }

    /**
     * @param $queueId
     * @return Queue
     * @throws NoSuchEntityException
     */
    public function getById($queueId)
    {
        $queue = $this->queueFactory->create();
        $this->queueResource->load($queue, $queueId);
        if(!$queue->getExportId()) {
            throw new NoSuchEntityException('Queue does not exist');
        }
        return $queue;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Lima\OrderExporter\Api\Data\QueueSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        foreach ($searchCriteria->getFilterGroups() as $group) {
            $this->addFilterGroupToCollection($group, $collection);
        }
        /** @var Magento\Framework\Api\SortOrder $sortOrder */
        foreach ((array)$searchCriteria->getSortOrders() as $sortOrder) {
            $field = $sortOrder->getField();
            $collection->addOrder(
                $field,
                $this->getDirection($sortOrder->getDirection())
            );

        }

        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->load();
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setCriteria($searchCriteria);

        $queues=[];
        foreach ($collection as $queue){
            $queues[] = $queue;
        }
        $searchResults->setItems($queues);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @param \Lima\OrderExporter\Api\Data\QueueInterface $queueId
     * @return bool
     * @throws \Exception
     */
    public function delete($queueId)
    {
        $queue = $this->queueFactory->create();
        $queue->setId($queueId);
        if( $this->queueResource->delete($queue)){
            return true;
        } else {
            return false;
        }
    }

    public function exportItem(\Lima\OrderExporter\Api\Data\QueueInterface $queue)
    {
        $queue = $this->getById($queue->getExportId());

        try {
            $this->api->export($queue);
            $queue->setPending(0);
        } catch (\Exception $e) {
            $queue->setPending(1);
            $errorMessage = (string) $e->getMessage();
            $queue->setErrorLog($errorMessage);
        }

        $queue->setUpdatedAt($this->coreDate->gmtDate());

        try {
            $this->save($queue);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            die;
        }
    }

    /**
     * @param $direction
     * @return bool|string
     */
    private function getDirection($direction)
    {
        return $direction == SortOrder::SORT_ASC ?: SortOrder::SORT_DESC;
    }

    /**
     * @param $group
     * @param $collection
     */
    private function addFilterGroupToCollection($group, $collection)
    {
        $fields = [];
        $conditions = [];

        foreach($group->getFilters() as $filter){
            $condition = $filter->getConditionType() ?: 'eq';
            $field = $filter->getField();
            $value = $filter->getValue();
            $fields[] = $field;
            $conditions[] = [$condition=>$value];

        }
        $collection->addFieldToFilter($fields, $conditions);
    }
}
