<?php

namespace Lima\OrderExporter\Block\Adminhtml\Queue\Edit\Buttons;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Lima\OrderExporter\Api\QueueRepositoryInterface;

/**
 * Class Generic
 * @package Lima\OrderExporter\Block\Adminhtml\Queue\Edit\Buttons
 */
class Generic
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var QueueRepositoryInterface
     */
    protected $queueRepository;

    /**
     * Generic constructor.
     * @param Context $context
     * @param QueueRepositoryInterface $queueRepository
     */
    public function __construct(
        Context $context,
        QueueRepositoryInterface $queueRepository
    ) {
        $this->context = $context;
        $this->queueRepository = $queueRepository;
    }

    /**
     * @return |null
     */
    public function getQueueId()
    {
        try {
            return $this->queueRepository->getById(
                $this->context->getRequest()->getParam('export_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
