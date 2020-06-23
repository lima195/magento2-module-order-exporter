<?php

namespace Lima\OrderExporter\Cron;

use \Psr\Log\LoggerInterface;
use Lima\OrderExporter\Model\ResourceModel\Queue\CollectionFactory;
use Lima\OrderExporter\Api\QueueRepositoryInterface as Queue;

class QueueRun
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var Queue
     */
    protected $queue;

    /**
     * QueueRun constructor.
     * @param LoggerInterface $logger
     * @param CollectionFactory $collectionFactory
     * @param Queue $queue
     */
    public function __construct(
        LoggerInterface $logger,
        CollectionFactory $collectionFactory,
        Queue $queue
    ) {
        $this->logger = $logger;
        $this->collectionFactory = $collectionFactory;
        $this->queue = $queue;
    }

    /**
     *
     */
    public function execute()
    {
        $collection = $this->_getCollection();
        $this->logger->info('Exporting Pending Orders');

        if($collection){
            foreach ($collection as $key => $item) {
                $this->logger->info('Exporting Orders: ' . $item->getExportId());
                $this->queue->exportItem($item);
            }
        }
    }

    /**
     * @return bool|\Lima\OrderExporter\Model\ResourceModel\Queue\Collection
     */
    private function _getCollection()
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('pending', ['eq' => 1])
                ->setPageSize(10)
                ->setCurPage(1)
                ->load();

        return $collection->count() ? $collection : false;
    }
}
