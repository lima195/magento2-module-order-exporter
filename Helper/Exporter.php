<?php
namespace Lima\OrderExporter\Helper;

use Lima\OrderExporter\Helper\AbstractData;
use Magento\Sales\Api\Data\OrderInterface;

/**
 * Class AbstractData
 * @package Lima\OrderExporter\Helper
 */
class Exporter extends AbstractData
{
    /**
     * @param OrderInterface $order
     * @return array
     */
    public function getPayloadByOrder(OrderInterface $order)
    {
        $payload = [];

        if($order->getIncrementId()) {
            $payload = [
                "customer" => $this->_getCustomerData($order),
                "shipping_address" => $this->_getShippingData($order),
                "items" => $this->_getItemsData($order),
                "shipping_method" => $order->getShippingMethod(),
                "payment_method" => $order->getPayment()->getMethod(),
                /**
                 * TODO - CHECK INSTALLMENTS
                 */
                "payment_installments" => $order->getPayment()->getAdditionalData(),
                "subtotal" => $order->getSubtotal(),
                "shipping_amount" => $order->getShippingAmount(),
                "discount" => $order->getDiscountAmount(),
                "total" => $order->getGrandTotal(),
            ];
        }

        return $payload;
    }

    /**
     * @param OrderInterface $order
     * @return array
     */
    protected function _getCustomerData(OrderInterface $order)
    {
        $address = $order->getShippingAddress();

        $data = [
            "name" => $order->getCustomerFirstname() . ' ' . $order->getCustomerLastname(),
            "cpf_cnpj" => $order->getCustomerTaxvat(),
            /**
             * TODO - FORMAT TELEPHONE AND ADD ADMIN OPTION FOR CHOOSE TO GET THIS VALUE FROM ADDRESS OR CUSTOMER
             */
            "telephone" => $address->getTelephone(),
            /**
             * TODO - REMOVE DOB TIME
             */
            "dob" => $order->getCustomerDob()
        ];

        if(strlen(preg_replace('/[^A-Za-z0-9\-]/', '', $order->getCustomerTaxvat())) >= 13) {
            /**
             * TODO - IMPLEMENT PJ FUNCTIONALITIES
             */
            $data['cnpj'] = $order->getCustomerTaxvat();
            $data['razao_social'] = 'sfasfa';
            $data['nome_fantasia'] = 'test';
            $data['ie'] = "00000000";
        }

        return $data;
    }

    /**
     * @param OrderInterface $order
     * @return array
     */
    protected function _getShippingData(OrderInterface $order)
    {
        $address = $order->getShippingAddress();
        $data = [];

        if($address->getId()){
            $data = [
                /**
                 * TODO - ADMIN OPTION TO MAPPER ADDRESSES
                 */
                "street" => $address->getStreet()[0],
                "number" => $address->getStreet()[1],
                "additional" => $address->getStreet()[3],
                "neighborhood" => $address->getStreet()[2],
                "city" =>  $address->getCity(),
                /**
                 * TODO - IMPORT IBGE DATA TO GET THIS CORRECT VALUE
                 */
                "city_ibge_code" => $address->getRegionId(),
                /**
                 * TODO - FORMAT UF TO 2 LETTERS PATTERN
                 */
                "uf" => $address->getRegion(),
                "country" => $address->getCountryId()
            ];
        }

        return $data;
    }

    /**
     * @param OrderInterface $order
     * @return array|mixed
     */
    protected function _getItemsData(OrderInterface $order)
    {
        $data = [];

        foreach ($order->getAllVisibleItems() as $key => $item) {
            $data[] = [
                "sku" => $item->getSku(),
                "name" => $item->getName(),
                "price" => $item->getPrice(),
                "qty" => $item->getQtyOrdered()
            ];
        }

        if(count($data) === 1) {
            $data = $data[0];
        }

        return $data;
    }
}
