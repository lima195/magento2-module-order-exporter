<?php

namespace Lima\OrderExporter\Model;

use Lima\OrderExporter\Api\SalesInterface;

/**
 * Class Sales
 * @package Lima\OrderExporter\Model
 */
class Sales implements SalesInterface
{
    /**
     * @param mixed $orderData
     * @return mixed
     * @throws \Exception
     */
	public function processOrder($orderData)
	{
	    $error = [];
	    if(isset($orderData[0])) {
	        $orderData = $orderData[0];
        }

	    // Check customer data
        $this->_checkStringNotNullValue('name', $orderData['customer'], $error);
        $this->_checkStringNotNullValue('cpf_cnpj', $orderData['customer'], $error);
        $this->_checkStringNotNullValue('telephone', $orderData['customer'], $error);
        $this->_checkStringNotNullValue('dob', $orderData['customer'], $error);

	    // Check shipping_address
        $this->_checkStringNotNullValue('street', $orderData['shipping_address'], $error);
        $this->_checkStringNotNullValue('number', $orderData['shipping_address'], $error);
        $this->_checkStringNotNullValue('neighborhood', $orderData['shipping_address'], $error);
        $this->_checkStringNotNullValue('city', $orderData['shipping_address'], $error);
        $this->_checkStringNotNullValue('city_ibge_code', $orderData['shipping_address'], $error);
        $this->_checkStringNotNullValue('uf', $orderData['shipping_address'], $error);
        $this->_checkStringNotNullValue('country', $orderData['shipping_address'], $error);

        // Check products data
        $this->_checkItems($orderData['items'], $error);

	    // Check order data
        $this->_checkStringNotNullValue('shipping_method', $orderData, $error);
        $this->_checkStringNotNullValue('payment_method', $orderData, $error);
        $this->_checkNumber('subtotal', $orderData, $error);
        $this->_checkNumber('shipping_amount', $orderData, $error);
        $this->_checkNumber('discount', $orderData, $error);
        $this->_checkNumber('total', $orderData, $error);

        if(!empty($error)) {
            return [
                'errors' => $error
            ];
        } else {
            return true;
        }
	}

    /**
     * @param string $field
     * @param array $orderData
     * @param $error
     */
	private function _checkNumber(string $field, array $orderData, &$error)
    {
        if((empty($orderData[$field]) && $orderData[$field] !== 0)  || is_nan($orderData[$field])) {
            $error[] = __('Missing %1 param', $field);
        }
    }

    /**
     * @param string $field
     * @param array $orderData
     * @param $error
     */
	private function _checkStringNotNullValue(string $field, array $orderData, &$error)
    {
        if(empty($orderData[$field]) || !is_string($orderData[$field])) {
            $error[] = __('Missing %1 param', $field);
        }
    }

    /**
     * @param $items
     * @param $error
     */
    private function _checkItems($items, &$error){
	    if(empty($items)) {
	        $error[] = __('Missing %1 param', 'items');
        }
    }
}
