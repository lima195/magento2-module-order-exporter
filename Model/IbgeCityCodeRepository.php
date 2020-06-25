<?php

namespace Lima\OrderExporter\Model;

use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;
use Lima\OrderExporter\Api\Data\IbgeCityCodeSearchResultsInterfaceFactory;
use Lima\OrderExporter\Api\IbgeCityCodeRepositoryInterface;
use Lima\OrderExporter\Model\ResourceModel\IbgeCityCode as IbgeCityCodeResource;
use Lima\OrderExporter\Model\ResourceModel\IbgeCityCode\CollectionFactory;

/**
 * Class IbgeCityCodeRepository
 * @package Lima\OrderExporter\Model
 */
class IbgeCityCodeRepository implements IbgeCityCodeRepositoryInterface
{
    /**
     * @var IbgeCityCodeResource
     */
    private $ibgeCityCodeResource;

    /**
     * @var IbgeCityCodeFactory
     */
    private $ibgeCityCodeFactory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var IbgeCityCodeSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * IbgeCityCodeRepository constructor.
     * @param IbgeCityCodeResource $ibgeCityCodeResource
     * @param IbgeCityCodeFactory $ibgeCityCodeFactory
     * @param CollectionFactory $collectionFactory
     * @param IbgeCityCodeSearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        IbgeCityCodeResource $ibgeCityCodeResource,
        IbgeCityCodeFactory $ibgeCityCodeFactory,
        CollectionFactory $collectionFactory,
        IbgeCityCodeSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->ibgeCityCodeResource = $ibgeCityCodeResource;
        $this->ibgeCityCodeFactory = $ibgeCityCodeFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @param \Lima\OrderExporter\Api\Data\IbgeCityCodeInterface $ibgeCityCode
     * @return mixed
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(\Lima\OrderExporter\Api\Data\IbgeCityCodeInterface $ibgeCityCode)
    {
        $this->ibgeCityCodeResource->save($ibgeCityCode);
        return $ibgeCityCode->getEntityId();
    }

    /**
     * @param $ibgeCityCodeId
     * @return IbgeCityCode
     * @throws NoSuchEntityException
     */
    public function getById($ibgeCityCodeId)
    {
        $ibgeCityCode = $this->ibgeCityCodeFactory->create();
        $this->ibgeCityCodeResource->load($ibgeCityCode, $ibgeCityCodeId);
        if(!$ibgeCityCode->getEntityId()) {
            throw new NoSuchEntityException('IbgeCityCode does not exist');
        }
        return $ibgeCityCode;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Lima\OrderExporter\Api\Data\IbgeCityCodeSearchResultsInterface
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

        $ibgeCityCodes=[];
        foreach ($collection as $ibgeCityCode){
            $ibgeCityCodes[] = $ibgeCityCode;
        }
        $searchResults->setItems($ibgeCityCodes);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @param \Lima\OrderExporter\Api\Data\IbgeCityCodeInterface $ibgeCityCodeId
     * @return bool
     * @throws \Exception
     */
    public function delete($ibgeCityCodeId)
    {
        $ibgeCityCode = $this->ibgeCityCodeFactory->create();
        $ibgeCityCode->setId($ibgeCityCodeId);
        if( $this->ibgeCityCodeResource->delete($ibgeCityCode)){
            return true;
        } else {
            return false;
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
