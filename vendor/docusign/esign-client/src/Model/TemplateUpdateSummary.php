<?php
/**
 * TemplateUpdateSummary
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
 * TemplateUpdateSummary Class Doc Comment
 *
 * @category    Class
 * @package     DocuSign\eSign
 * @author      Swagger Codegen team <apihelp@docusign.com>
 * @license     The Docusign PHP Client SDK is licensed under the MIT License.
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class TemplateUpdateSummary implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'templateUpdateSummary';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'bulk_envelope_status' => '\DocuSign\eSign\Model\BulkEnvelopeStatus',
        'envelope_id' => '?string',
        'error_details' => '\DocuSign\eSign\Model\ErrorDetails',
        'list_custom_field_update_results' => '\DocuSign\eSign\Model\ListCustomField[]',
        'lock_information' => '\DocuSign\eSign\Model\LockInformation',
        'purge_state' => '?string',
        'recipient_update_results' => '\DocuSign\eSign\Model\RecipientUpdateResponse[]',
        'tab_update_results' => '\DocuSign\eSign\Model\Tabs',
        'text_custom_field_update_results' => '\DocuSign\eSign\Model\TextCustomField[]'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'bulk_envelope_status' => null,
        'envelope_id' => null,
        'error_details' => null,
        'list_custom_field_update_results' => null,
        'lock_information' => null,
        'purge_state' => null,
        'recipient_update_results' => null,
        'tab_update_results' => null,
        'text_custom_field_update_results' => null
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
        'bulk_envelope_status' => 'bulkEnvelopeStatus',
        'envelope_id' => 'envelopeId',
        'error_details' => 'errorDetails',
        'list_custom_field_update_results' => 'listCustomFieldUpdateResults',
        'lock_information' => 'lockInformation',
        'purge_state' => 'purgeState',
        'recipient_update_results' => 'recipientUpdateResults',
        'tab_update_results' => 'tabUpdateResults',
        'text_custom_field_update_results' => 'textCustomFieldUpdateResults'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'bulk_envelope_status' => 'setBulkEnvelopeStatus',
        'envelope_id' => 'setEnvelopeId',
        'error_details' => 'setErrorDetails',
        'list_custom_field_update_results' => 'setListCustomFieldUpdateResults',
        'lock_information' => 'setLockInformation',
        'purge_state' => 'setPurgeState',
        'recipient_update_results' => 'setRecipientUpdateResults',
        'tab_update_results' => 'setTabUpdateResults',
        'text_custom_field_update_results' => 'setTextCustomFieldUpdateResults'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'bulk_envelope_status' => 'getBulkEnvelopeStatus',
        'envelope_id' => 'getEnvelopeId',
        'error_details' => 'getErrorDetails',
        'list_custom_field_update_results' => 'getListCustomFieldUpdateResults',
        'lock_information' => 'getLockInformation',
        'purge_state' => 'getPurgeState',
        'recipient_update_results' => 'getRecipientUpdateResults',
        'tab_update_results' => 'getTabUpdateResults',
        'text_custom_field_update_results' => 'getTextCustomFieldUpdateResults'
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
        $this->container['bulk_envelope_status'] = isset($data['bulk_envelope_status']) ? $data['bulk_envelope_status'] : null;
        $this->container['envelope_id'] = isset($data['envelope_id']) ? $data['envelope_id'] : null;
        $this->container['error_details'] = isset($data['error_details']) ? $data['error_details'] : null;
        $this->container['list_custom_field_update_results'] = isset($data['list_custom_field_update_results']) ? $data['list_custom_field_update_results'] : null;
        $this->container['lock_information'] = isset($data['lock_information']) ? $data['lock_information'] : null;
        $this->container['purge_state'] = isset($data['purge_state']) ? $data['purge_state'] : null;
        $this->container['recipient_update_results'] = isset($data['recipient_update_results']) ? $data['recipient_update_results'] : null;
        $this->container['tab_update_results'] = isset($data['tab_update_results']) ? $data['tab_update_results'] : null;
        $this->container['text_custom_field_update_results'] = isset($data['text_custom_field_update_results']) ? $data['text_custom_field_update_results'] : null;
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
     * Gets bulk_envelope_status
     *
     * @return \DocuSign\eSign\Model\BulkEnvelopeStatus
     */
    public function getBulkEnvelopeStatus()
    {
        return $this->container['bulk_envelope_status'];
    }

    /**
     * Sets bulk_envelope_status
     *
     * @param \DocuSign\eSign\Model\BulkEnvelopeStatus $bulk_envelope_status An object that describes the status of the bulk send envelopes.
     *
     * @return $this
     */
    public function setBulkEnvelopeStatus($bulk_envelope_status)
    {
        $this->container['bulk_envelope_status'] = $bulk_envelope_status;

        return $this;
    }

    /**
     * Gets envelope_id
     *
     * @return ?string
     */
    public function getEnvelopeId()
    {
        return $this->container['envelope_id'];
    }

    /**
     * Sets envelope_id
     *
     * @param ?string $envelope_id The envelope ID of the envelope status that failed to post.
     *
     * @return $this
     */
    public function setEnvelopeId($envelope_id)
    {
        $this->container['envelope_id'] = $envelope_id;

        return $this;
    }

    /**
     * Gets error_details
     *
     * @return \DocuSign\eSign\Model\ErrorDetails
     */
    public function getErrorDetails()
    {
        return $this->container['error_details'];
    }

    /**
     * Sets error_details
     *
     * @param \DocuSign\eSign\Model\ErrorDetails $error_details Array or errors.
     *
     * @return $this
     */
    public function setErrorDetails($error_details)
    {
        $this->container['error_details'] = $error_details;

        return $this;
    }

    /**
     * Gets list_custom_field_update_results
     *
     * @return \DocuSign\eSign\Model\ListCustomField[]
     */
    public function getListCustomFieldUpdateResults()
    {
        return $this->container['list_custom_field_update_results'];
    }

    /**
     * Sets list_custom_field_update_results
     *
     * @param \DocuSign\eSign\Model\ListCustomField[] $list_custom_field_update_results 
     *
     * @return $this
     */
    public function setListCustomFieldUpdateResults($list_custom_field_update_results)
    {
        $this->container['list_custom_field_update_results'] = $list_custom_field_update_results;

        return $this;
    }

    /**
     * Gets lock_information
     *
     * @return \DocuSign\eSign\Model\LockInformation
     */
    public function getLockInformation()
    {
        return $this->container['lock_information'];
    }

    /**
     * Sets lock_information
     *
     * @param \DocuSign\eSign\Model\LockInformation $lock_information Provides lock information about an envelope that a user has locked.
     *
     * @return $this
     */
    public function setLockInformation($lock_information)
    {
        $this->container['lock_information'] = $lock_information;

        return $this;
    }

    /**
     * Gets purge_state
     *
     * @return ?string
     */
    public function getPurgeState()
    {
        return $this->container['purge_state'];
    }

    /**
     * Sets purge_state
     *
     * @param ?string $purge_state 
     *
     * @return $this
     */
    public function setPurgeState($purge_state)
    {
        $this->container['purge_state'] = $purge_state;

        return $this;
    }

    /**
     * Gets recipient_update_results
     *
     * @return \DocuSign\eSign\Model\RecipientUpdateResponse[]
     */
    public function getRecipientUpdateResults()
    {
        return $this->container['recipient_update_results'];
    }

    /**
     * Sets recipient_update_results
     *
     * @param \DocuSign\eSign\Model\RecipientUpdateResponse[] $recipient_update_results 
     *
     * @return $this
     */
    public function setRecipientUpdateResults($recipient_update_results)
    {
        $this->container['recipient_update_results'] = $recipient_update_results;

        return $this;
    }

    /**
     * Gets tab_update_results
     *
     * @return \DocuSign\eSign\Model\Tabs
     */
    public function getTabUpdateResults()
    {
        return $this->container['tab_update_results'];
    }

    /**
     * Sets tab_update_results
     *
     * @param \DocuSign\eSign\Model\Tabs $tab_update_results 
     *
     * @return $this
     */
    public function setTabUpdateResults($tab_update_results)
    {
        $this->container['tab_update_results'] = $tab_update_results;

        return $this;
    }

    /**
     * Gets text_custom_field_update_results
     *
     * @return \DocuSign\eSign\Model\TextCustomField[]
     */
    public function getTextCustomFieldUpdateResults()
    {
        return $this->container['text_custom_field_update_results'];
    }

    /**
     * Sets text_custom_field_update_results
     *
     * @param \DocuSign\eSign\Model\TextCustomField[] $text_custom_field_update_results 
     *
     * @return $this
     */
    public function setTextCustomFieldUpdateResults($text_custom_field_update_results)
    {
        $this->container['text_custom_field_update_results'] = $text_custom_field_update_results;

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

