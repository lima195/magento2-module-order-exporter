<?php
namespace Lima\OrderExporter\Block\Adminhtml\System\Config;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

/**
 * Class TypeCPF
 * @package Lima\OrderExporter\Block\Adminhtml\System\Config
 */
class TypeCPF implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @return array
     */
   public function toOptionArray()
    {
        return [
            'customer' => __ ('by customer form (customer account)'),
            'address' => __('by address form (checkout)'),
        ];
    }
}
