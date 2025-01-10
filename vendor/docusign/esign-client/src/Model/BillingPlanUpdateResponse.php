<?php
/**
 * BillingPlanUpdateResponse
 *
 * PHP version 7.4
 *
 * @category Class
 * @package  DocuSign\eSign
 * @author   Swagger Codegen team <apihelp@docusign.com>
 * @license  The Docusign PHP Client SDK is licensed under the MIT License.
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * Docusign eSignature REST API
 *
 * The Docusign eSignature REST API provides you with a powerful, convenient, and simple Web services API for interacting with Docusign.
 *
 * OpenAPI spec version: v2.1
 * Contact: devcenter@docusign.com
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * Swagger Codegen version: 2.4.21
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace DocuSign\eSign\Model;

use \ArrayAccess;
use DocuSign\eSign\ObjectSerializer;

/**
 * BillingPlanUpdateResponse Class Doc Comment
 *
 * @category    Class
 * @description Defines a billing plan update response object.
 * @package     DocuSign\eSign
 * @author      Swagger Codegen team <apihelp@docusign.com>
 * @license     The Docusign PHP Client SDK is licensed under the MIT License.
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class BillingPlanUpdateResponse implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'billingPlanUpdateResponse';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'account_payment_method' => '?string',
        'billing_plan_preview' => '\DocuSign\eSign\Model\BillingPlanPreview',
        'currency_code' => '?string',
        'included_seats' => '?string',
        'payment_cycle' => '?string',
        'payment_method' => '?string',
        'plan_id' => '?string',
        'plan_name' => '?string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'account_payment_method' => null,
        'billing_plan_preview' => null,
        'currency_code' => null,
        'included_seats' => null,
        'payment_cycle' => null,
        'payment_method' => null,
        'plan_id' => null,
        'plan_name' => null
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'account_payment_method' => 'accountPaymentMethod',
        'billing_plan_preview' => 'billingPlanPreview',
        'currency_code' => 'currencyCode',
        'included_seats' => 'includedSeats',
        'payment_cycle' => 'paymentCycle',
        'payment_method' => 'paymentMethod',
        'plan_id' => 'planId',
        'plan_name' => 'planName'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'account_payment_method' => 'setAccountPaymentMethod',
        'billing_plan_preview' => 'setBillingPlanPreview',
        'currency_code' => 'setCurrencyCode',
        'included_seats' => 'setIncludedSeats',
        'payment_cycle' => 'setPaymentCycle',
        'payment_method' => 'setPaymentMethod',
        'plan_id' => 'setPlanId',
        'plan_name' => 'setPlanName'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'account_payment_method' => 'getAccountPaymentMethod',
        'billing_plan_preview' => 'getBillingPlanPreview',
        'currency_code' => 'getCurrencyCode',
        'included_seats' => 'getIncludedSeats',
        'payment_cycle' => 'getPaymentCycle',
        'payment_method' => 'getPaymentMethod',
        'plan_id' => 'getPlanId',
        'plan_name' => 'getPlanName'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$swaggerModelName;
    }

    

    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['account_payment_method'] = isset($data['account_payment_method']) ? $data['account_payment_method'] : null;
        $this->container['billing_plan_preview'] = isset($data['billing_plan_preview']) ? $data['billing_plan_preview'] : null;
        $this->container['currency_code'] = isset($data['currency_code']) ? $data['currency_code'] : null;
        $this->container['included_seats'] = isset($data['included_seats']) ? $data['included_seats'] : null;
        $this->container['payment_cycle'] = isset($data['payment_cycle']) ? $data['payment_cycle'] : null;
        $this->container['payment_method'] = isset($data['payment_method']) ? $data['payment_method'] : null;
        $this->container['plan_id'] = isset($data['plan_id']) ? $data['plan_id'] : null;
        $this->container['plan_name'] = isset($data['plan_name']) ? $data['plan_name'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets account_payment_method
     *
     * @return ?string
     */
    public function getAccountPaymentMethod()
    {
        return $this->container['account_payment_method'];
    }

    /**
     * Sets account_payment_method
     *
     * @param ?string $account_payment_method 
     *
     * @return $this
     */
    public function setAccountPaymentMethod($account_payment_method)
    {
        $this->container['account_payment_method'] = $account_payment_method;

        return $this;
    }

    /**
     * Gets billing_plan_preview
     *
     * @return \DocuSign\eSign\Model\BillingPlanPreview
     */
    public function getBillingPlanPreview()
    {
        return $this->container['billing_plan_preview'];
    }

    /**
     * Sets billing_plan_preview
     *
     * @param \DocuSign\eSign\Model\BillingPlanPreview $billing_plan_preview 
     *
     * @return $this
     */
    public function setBillingPlanPreview($billing_plan_preview)
    {
        $this->container['billing_plan_preview'] = $billing_plan_preview;

        return $this;
    }

    /**
     * Gets currency_code
     *
     * @return ?string
     */
    public function getCurrencyCode()
    {
        return $this->container['currency_code'];
    }

    /**
     * Sets currency_code
     *
     * @param ?string $currency_code Specifies the ISO currency code for the account.
     *
     * @return $this
     */
    public function setCurrencyCode($currency_code)
    {
        $this->container['currency_code'] = $currency_code;

        return $this;
    }

    /**
     * Gets included_seats
     *
     * @return ?string
     */
    public function getIncludedSeats()
    {
        return $this->container['included_seats'];
    }

    /**
     * Sets included_seats
     *
     * @param ?string $included_seats The number of seats (users) included.
     *
     * @return $this
     */
    public function setIncludedSeats($included_seats)
    {
        $this->container['included_seats'] = $included_seats;

        return $this;
    }

    /**
     * Gets payment_cycle
     *
     * @return ?string
     */
    public function getPaymentCycle()
    {
        return $this->container['payment_cycle'];
    }

    /**
     * Sets payment_cycle
     *
     * @param ?string $payment_cycle 
     *
     * @return $this
     */
    public function setPaymentCycle($payment_cycle)
    {
        $this->container['payment_cycle'] = $payment_cycle;

        return $this;
    }

    /**
     * Gets payment_method
     *
     * @return ?string
     */
    public function getPaymentMethod()
    {
        return $this->container['payment_method'];
    }

    /**
     * Sets payment_method
     *
     * @param ?string $payment_method 
     *
     * @return $this
     */
    public function setPaymentMethod($payment_method)
    {
        $this->container['payment_method'] = $payment_method;

        return $this;
    }

    /**
     * Gets plan_id
     *
     * @return ?string
     */
    public function getPlanId()
    {
        return $this->container['plan_id'];
    }

    /**
     * Sets plan_id
     *
     * @param ?string $plan_id 
     *
     * @return $this
     */
    public function setPlanId($plan_id)
    {
        $this->container['plan_id'] = $plan_id;

        return $this;
    }

    /**
     * Gets plan_name
     *
     * @return ?string
     */
    public function getPlanName()
    {
        return $this->container['plan_name'];
    }

    /**
     * Sets plan_name
     *
     * @param ?string $plan_name 
     *
     * @return $this
     */
    public function setPlanName($plan_name)
    {
        $this->container['plan_name'] = $plan_name;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    #[\ReturnTypeWillChange]
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param integer $offset Offset
     * @param mixed   $value  Value to be set
     *
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}

