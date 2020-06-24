<?php

namespace Lima\OrderExporter\Controller\Adminhtml\Queue;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Lima\OrderExporter\Model\ResourceModel\Queue\CollectionFactory;
use Lima\OrderExporter\Api\QueueRepositoryInterface as Queue;
use \Psr\Log\LoggerInterface;

/**
 * Class MassExport
 * @package Lima\OrderExporter\Controller\Adminhtml\Queue
 */
class MassExport extends \Magento\Backend\App\Action
{
    /**
     * @var Filter
     */
    protected $_filter;

    /**
     * @var CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var Queue
     */
    protected $queue;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * MassExport constructor.
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param LoggerInterface $logger
     * @param Queue $queue
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        LoggerInterface $logger,
        Queue $queue
    ) {
        $this->_filter = $filter;
        $this->_collectionFactory = $collectionFactory;
        $this->queue = $queue;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Redirect|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        if (!$this->getRequest()->isPost()) {
            throw new \Magento\Framework\Exception\NotFoundException(__('Page not found.'));
        }

        $collection = $this->_filter->getCollection($this->_collectionFactory->create());
        $collectionSize = $collection->getSize();
        $successExported = 0;

        foreach ($collection as $queueItem) {
            $this->logger->info('Exporting Orders: ' . $queueItem->getExportId());
            $result = $this->queue->exportItem($queueItem);
            if($result) {
                $successExported++;
            }
        }

        if($successExported) {
            $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been exported.', $successExported));
        }

        $this->messageManager->addErrorMessage(__('A total of %1 record(s) have not been exported.', ($collectionSize - $successExported)));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
