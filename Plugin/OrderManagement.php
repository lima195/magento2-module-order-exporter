<?php

namespace Lima\OrderExporter\Plugin;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderManagementInterface;
use Lima\OrderExporter\Api\Data\QueueInterface;
use Lima\OrderExporter\Api\QueueRepositoryInterface;
use Lima\OrderExporter\Helper\Exporter as ExporterHelper;

/**
 * Class OrderManagement
 * @package Lima\OrderExporter\Plugin
 */
class OrderManagement
{
    /**
     * @var QueueRepositoryInterface
     */
    protected $queueRepository;

    /**
     * @var Queue
     */
    protected $queue;

    /**
     * @var ExporterHelper
     */
    protected $exporterHelper;

    /**
     * OrderManagement constructor.
     * @param QueueRepositoryInterface $queueRepository
     */
    public function __construct(
        QueueInterface $queue,
        QueueRepositoryInterface $queueRepository,
        ExporterHelper $exporterHelper
    ) {
        $this->queueRepository  = $queueRepository;
        $this->queue  = $queue;
        $this->exporterHelper  = $exporterHelper;
    }

    /**
     * @param OrderManagementInterface $subject
     * @param OrderInterface $result
     * @return OrderInterface
     */
    public function afterPlace(
        OrderManagementInterface $subject,
        OrderInterface $result
    ) {
        $order = $result;
        if ($order->getIncrementId()) {
            $payload = $this->exporterHelper->getPayloadByOrder($order);
        	$queue = $this->queue->setOrderId($order->getEntityId())
                ->setPayload(json_encode($payload))
        	    ->setErrorLog('ok')
                ->setPending(1);

            try {
        	    $this->queueRepository->save($queue);
            } catch (\Exception $e) {
                var_dump($e);
                die;
            }
        }
        return $result;
    }
}
