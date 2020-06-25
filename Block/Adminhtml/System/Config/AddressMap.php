<?php
namespace Lima\OrderExporter\Block\Adminhtml\System\Config;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Customer\Model;
use Magento\Customer\Model\AddressFactory;

/**
 * Class AddressMap
 * @package Lima\OrderExporter\Block\Adminhtml\System\Config
 */
class AddressMap implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var AddressFactory
     */
    protected $addressFactory;

    /**
     * AddressMap constructor.
     * @param AddressFactory $addressFactory
     */
    public function __construct(
        AddressFactory $addressFactory
    ) {
       $this->addressFactory = $addressFactory;
    }

    /**
     * @return array
     */
	public function toOptionArray()
    {
        $address = $this->addressFactory->create();
        $customer_attributes = $address->getAttributes();

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
