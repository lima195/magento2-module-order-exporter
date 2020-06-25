<?php
namespace Lima\OrderExporter\Block\Adminhtml\System\Config;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Customer\Model;

/**
 * Class CustomerMap
 * @package Lima\OrderExporter\Block\Adminhtml\System\Config
 */
class CustomerMap implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var Model\CustomerFactory
     */
    protected $customerFactory;

    /**
     * CustomerMap constructor.
     * @param Model\CustomerFactory $customerFactory
     */
    public function __construct(
        \Magento\Customer\Model\CustomerFactory $customerFactory
    ) {
       $this->customerFactory = $customerFactory;
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
	public function toOptionArray()
    {
        $customer_attributes = $this->customerFactory->create()->getAttributes();

        $attributesArrays = [];

           foreach($customer_attributes as $cal=>$val){
               $attributesArrays[] = [
                   'label' => $cal,
                   'value' => $cal
               ];
           }

        return $attributesArrays;
    }
}
