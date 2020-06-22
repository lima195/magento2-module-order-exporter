<?php
namespace Lima\OrderExporter\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Lima\OrderExporter\Api\QueueRepositoryInterface;

/**
 * Class Queue
 * @package Lima\OrderExporter\Controller\Adminhtml
 */
abstract class Queue extends Action
{
    const ACTION_RESOURCE = 'Lima_OrderExporter::queue';

    /**
     * @var QueueRepositoryInterface
     */
    protected $queueRepository;

    /**
     * @var
     */
    protected $coreRegistry;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Queue constructor.
     * @param QueueRepositoryInterface $queueRepository
     * @param PageFactory $resultPageFactory
     * @param Context $context
     */
    public function __construct(
        QueueRepositoryInterface $queueRepository,
        PageFactory $resultPageFactory,
        Context $context

    ) {
        $this->queueRepository  = $queueRepository;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

}
