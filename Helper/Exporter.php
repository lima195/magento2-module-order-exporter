<?php
namespace Lima\OrderExporter\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Lima\OrderExporter\Model\ResourceModel\IbgeCityCode\CollectionFactory as IbgeCollectionFactory;

/**
 * Class AbstractData
 * @package Lima\OrderExporter\Helper
 */
class Exporter extends \Lima\OrderExporter\Helper\AbstractData
{

    /**
     * @var IbgeCollectionFactory
     */
    protected $ibgeCollectionFactory;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Exporter constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param IbgeCollectionFactory $ibgeCollectionFactory
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        IbgeCollectionFactory $ibgeCollectionFactory,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->ibgeCollectionFactory  = $ibgeCollectionFactory;
        $this->logger = $logger;
        parent::__construct($scopeConfig);
    }

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
            "telephone" => $address->getTelephone(),
            "dob" => $this->_threatDate($order->getCustomerDob()),
        ];

        if(strlen(preg_replace('/[^A-Za-z0-9\-]/', '', $order->getCustomerTaxvat())) >= 13) {
            /**
             * TODO - IMPLEMENT PJ FUNCTIONALITIES
             */
            $data['cnpj'] = $order->getCustomerTaxvat();
            $data['razao_social'] = $order->getCustomerName();
            $data['nome_fantasia'] = $order->getCustomerName();
            $data['ie'] = $order->getCustomerTaxvat();
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

            if($this->getIsIbgeCodeEnabled()) {

                $collection = $this->ibgeCollectionFactory->create();
                $ibgeCity = $collection->addFieldToFilter('city_name', ['eq' => $address->getCity()])
                                ->addFieldToFilter('uf_name', ['eq' => $address->getRegion()])
                                ->getFirstItem();

                $ibgeValue = $address->getRegionId();

                if(!empty($ibgeCity->getCityCodeComplete()) || !empty($ibgeCity->getCityCode())) {
                    $ibgeValue = $this->getUseIbgeCityCodeComplete() ? $ibgeCity->getCityCodeComplete() : $ibgeCity->getCityCode();
                }

                $data["city_ibge_code"] = $ibgeValue;
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
                $this->logger->critical('Error message', ['exception' => $e]);
            }
        }

        return !empty($newDate) ? (string) $newDate : (string) $date;
    }
}
