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
            "dob" => $this->_threatDate($order->getCustomerDob()),
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
                "street" => $address->getStreet()[$this->getStreetLogradouro()],
                "number" => $address->getStreet()[$this->getStreetNumber()],
                "additional" => $address->getStreet()[$this->getStreetComplement()],
                "neighborhood" => $address->getStreet()[$this->getStreetDistrict()],
                "city" =>  $address->getCity(),
                "uf" => $this->_getBrazilianStates($address->getRegion()),
                "country" => $address->getCountryId()
            ];

            /**
             * TODO - IMPORT IBGE DATA TO GET THIS CORRECT VALUE
             */
            if($this->getIsIbgeCodeEnabled()) {
                $data["city_ibge_code"] = $address->getRegionId();
            }
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

    /**
     * @param null $state
     * @return string|string[]
     */
    protected function _getBrazilianStates($state = null)
    {
        $states = [
            "Acre" => "AC",
            "Alagoas" => "AL",
            "Amapá" => "AP",
            "Amazonas" => "AM",
            "Bahia" => "BA",
            "Ceará" => "CE",
            "Distrito Federal" => "DF",
            "Espírito Santo" => "ES",
            "Goiás" => "GO",
            "Maranhão" => "MA",
            "Mato Grosso" => "MT",
            "Mato Grosso do Sul" => "MS",
            "Minas Gerais" => "MG",
            "Pará" => "PA",
            "Paraíba" => "PB",
            "Paraná" => "PR",
            "Pernambuco" => "PE",
            "Piauí" => "PI",
            "Rio de Janeiro" => "RJ",
            "Rio Grande do Norte" => "RN",
            "Rio Grande do Sul" => "RS",
            "Rondônia" => "RO",
            "Roraima" => "RR",
            "Santa Catarina" => "SC",
            "São Paulo" => "SP",
            "Sergipe" => "SE",
            "Tocantins" => "TO"
        ];

        if($state) {
            return $states[$state] ? $states[$state] : $state;
        }

        return $states;
    }

    function _threatDate($date = null)
    {
        if($date) {
            try {
                $loadDate = \DateTime::createFromFormat("Y-m-d H:i:s", $date);
                $newDate = $loadDate->format($this->getDateFormat());
            } catch (\Exception $e) {
                /**
                 * TODO - LOGGER ERROR
                 */
            }
        }

        return !empty($newDate) ? (string) $newDate : (string) $date;
    }
}
