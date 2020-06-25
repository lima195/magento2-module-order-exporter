<?php
namespace Lima\OrderExporter\Block\Adminhtml\System\Config;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

/**
 * Class Street
 * @package Lima\OrderExporter\Block\Adminhtml\System\Config
 */
class Street implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @return array|string[]
     */
   public function toOptionArray()
    {
        return [
            '0' => '1st line of the street',
            '1' => '2st line of the street',
            '2' => '3st line of the street',
            '3' => '4st line of the street'
        ];
    }
}
