<?php
/**
 * Sample_News extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category  Sample
 * @package   Sample_News
 * @copyright 2016 Marius Strajeru
 * @license   http://opensource.org/licenses/mit-license.php MIT License
 * @export    Marius Strajeru
 */
namespace Lima\OrderExporter\Controller\Adminhtml\Queue;

use Lima\OrderExporter\Controller\Adminhtml\Queue;

/**
 * Class View
 * @package Lima\OrderExporter\Controller\Adminhtml\Queue
 */
class View extends Queue
{
    /**
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $exportId = $this->getRequest()->getParam('export_id');

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Lima_OrderExporter::queue');
        $resultPage->getConfig()->getTitle()->prepend(__('Queue'));

        if ($exportId === null) {
            die('redirect');
        } else {
            $resultPage->addBreadcrumb(__('Edit Queue'), __('Edit Queue'));
            $resultPage->getConfig()->getTitle()->prepend(
                __('Order ' . $this->queueRepository->getById($exportId)->getOrderId())
            );
        }
        return $resultPage;
    }
}
