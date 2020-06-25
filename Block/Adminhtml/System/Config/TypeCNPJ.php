<?php
namespace Lima\OrderExporter\Block\Adminhtml\System\Config;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

/**
 * Class TypeCNPJ
 * @package Lima\OrderExporter\Block\Adminhtml\System\Config
 */
class TypeCNPJ implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @return array
     */
   public function toOptionArray()
    {
        return [
            'use_cpf' => __('will use the same value as the CPF'),
            'use_customer' => __ ('by customer form (customer account)'),
            'use_address' => __('by address form (checkout)'),
        ];
    }
}
