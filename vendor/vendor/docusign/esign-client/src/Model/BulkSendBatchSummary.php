<?php
/**
 * BulkSendBatchSummary
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
 * BulkSendBatchSummary Class Doc Comment
 *
 * @category    Class
 * @description Summary status of a single batch.
 * @package     DocuSign\eSign
 * @author      Swagger Codegen team <apihelp@docusign.com>
 * @license     The Docusign PHP Client SDK is licensed under the MIT License.
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class BulkSendBatchSummary implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'bulkSendBatchSummary';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'action' => '?string',
        'action_status' => '?string',
        'batch_id' => '?string',
        'batch_name' => '?string',
        'batch_size' => '?string',
        'batch_uri' => '?string',
        'failed' => '?string',
        'queued' => '?string',
        'sent' => '?string',
        'submitted_date' => '?string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'action' => null,
        'action_status' => null,
        'batch_id' => null,
        'batch_name' => null,
        'batch_size' => null,
        'batch_uri' => null,
        'failed' => null,
        'queued' => null,
        'sent' => null,
        'submitted_date' => null
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
        'action' => 'action',
        'action_status' => 'actionStatus',
        'batch_id' => 'batchId',
        'batch_name' => 'batchName',
        'batch_size' => 'batchSize',
        'batch_uri' => 'batchUri',
        'failed' => 'failed',
        'queued' => 'queued',
        'sent' => 'sent',
        'submitted_date' => 'submittedDate'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'action' => 'setAction',
        'action_status' => 'setActionStatus',
        'batch_id' => 'setBatchId',
        'batch_name' => 'setBatchName',
        'batch_size' => 'setBatchSize',
        'batch_uri' => 'setBatchUri',
        'failed' => 'setFailed',
        'queued' => 'setQueued',
        'sent' => 'setSent',
        'submitted_date' => 'setSubmittedDate'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'action' => 'getAction',
        'action_status' => 'getActionStatus',
        'batch_id' => 'getBatchId',
        'batch_name' => 'getBatchName',
        'batch_size' => 'getBatchSize',
        'batch_uri' => 'getBatchUri',
        'failed' => 'getFailed',
        'queued' => 'getQueued',
        'sent' => 'getSent',
        'submitted_date' => 'getSubmittedDate'
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
        $this->container['action'] = isset($data['action']) ? $data['action'] : null;
        $this->container['action_status'] = isset($data['action_status']) ? $data['action_status'] : null;
        $this->container['batch_id'] = isset($data['batch_id']) ? $data['batch_id'] : null;
        $this->container['batch_name'] = isset($data['batch_name']) ? $data['batch_name'] : null;
        $this->container['batch_size'] = isset($data['batch_size']) ? $data['batch_size'] : null;
        $this->container['batch_uri'] = isset($data['batch_uri']) ? $data['batch_uri'] : null;
        $this->container['failed'] = isset($data['failed']) ? $data['failed'] : null;
        $this->container['queued'] = isset($data['queued']) ? $data['queued'] : null;
        $this->container['sent'] = isset($data['sent']) ? $data['sent'] : null;
        $this->container['submitted_date'] = isset($data['submitted_date']) ? $data['submitted_date'] : null;
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
     * Gets action
     *
     * @return ?string
     */
    public function getAction()
    {
        return $this->container['action'];
    }

    /**
     * Sets action
     *
     * @param ?string $action 
     *
     * @return $this
     */
    public function setAction($action)
    {
        $this->container['action'] = $action;

        return $this;
    }

    /**
     * Gets action_status
     *
     * @return ?string
     */
    public function getActionStatus()
    {
        return $this->container['action_status'];
    }

    /**
     * Sets action_status
     *
     * @param ?string $action_status 
     *
     * @return $this
     */
    public function setActionStatus($action_status)
    {
        $this->container['action_status'] = $action_status;

        return $this;
    }

    /**
     * Gets batch_id
     *
     * @return ?string
     */
    public function getBatchId()
    {
        return $this->container['batch_id'];
    }

    /**
     * Sets batch_id
     *
     * @param ?string $batch_id 
     *
     * @return $this
     */
    public function setBatchId($batch_id)
    {
        $this->container['batch_id'] = $batch_id;

        return $this;
    }

    /**
     * Gets batch_name
     *
     * @return ?string
     */
    public function getBatchName()
    {
        return $this->container['batch_name'];
    }

    /**
     * Sets batch_name
     *
     * @param ?string $batch_name 
     *
     * @return $this
     */
    public function setBatchName($batch_name)
    {
        $this->container['batch_name'] = $batch_name;

        return $this;
    }

    /**
     * Gets batch_size
     *
     * @return ?string
     */
    public function getBatchSize()
    {
        return $this->container['batch_size'];
    }

    /**
     * Sets batch_size
     *
     * @param ?string $batch_size 
     *
     * @return $this
     */
    public function setBatchSize($batch_size)
    {
        $this->container['batch_size'] = $batch_size;

        return $this;
    }

    /**
     * Gets batch_uri
     *
     * @return ?string
     */
    public function getBatchUri()
    {
        return $this->container['batch_uri'];
    }

    /**
     * Sets batch_uri
     *
     * @param ?string $batch_uri 
     *
     * @return $this
     */
    public function setBatchUri($batch_uri)
    {
        $this->container['batch_uri'] = $batch_uri;

        return $this;
    }

    /**
     * Gets failed
     *
     * @return ?string
     */
    public function getFailed()
    {
        return $this->container['failed'];
    }

    /**
     * Sets failed
     *
     * @param ?string $failed 
     *
     * @return $this
     */
    public function setFailed($failed)
    {
        $this->container['failed'] = $failed;

        return $this;
    }

    /**
     * Gets queued
     *
     * @return ?string
     */
    public function getQueued()
    {
        return $this->container['queued'];
    }

    /**
     * Sets queued
     *
     * @param ?string $queued 
     *
     * @return $this
     */
    public function setQueued($queued)
    {
        $this->container['queued'] = $queued;

        return $this;
    }

    /**
     * Gets sent
     *
     * @return ?string
     */
    public function getSent()
    {
        return $this->container['sent'];
    }

    /**
     * Sets sent
     *
     * @param ?string $sent 
     *
     * @return $this
     */
    public function setSent($sent)
    {
        $this->container['sent'] = $sent;

        return $this;
    }

    /**
     * Gets submitted_date
     *
     * @return ?string
     */
    public function getSubmittedDate()
    {
        return $this->container['submitted_date'];
    }

    /**
     * Sets submitted_date
     *
     * @param ?string $submitted_date 
     *
     * @return $this
     */
    public function setSubmittedDate($submitted_date)
    {
        $this->container['submitted_date'] = $submitted_date;

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

