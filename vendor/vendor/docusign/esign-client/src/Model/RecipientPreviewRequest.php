<?php
/**
 * RecipientPreviewRequest
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
 * RecipientPreviewRequest Class Doc Comment
 *
 * @category    Class
 * @description This request object contains the information necessary to create a recipient preview.
 * @package     DocuSign\eSign
 * @author      Swagger Codegen team <apihelp@docusign.com>
 * @license     The Docusign PHP Client SDK is licensed under the MIT License.
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class RecipientPreviewRequest implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'recipientPreviewRequest';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'assertion_id' => '?string',
        'authentication_instant' => '?string',
        'authentication_method' => '?string',
        'client_ur_ls' => '\DocuSign\eSign\Model\RecipientTokenClientURLs',
        'ping_frequency' => '?string',
        'ping_url' => '?string',
        'recipient_id' => '?string',
        'return_url' => '?string',
        'security_domain' => '?string',
        'x_frame_options' => '?string',
        'x_frame_options_allow_from_url' => '?string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'assertion_id' => null,
        'authentication_instant' => null,
        'authentication_method' => null,
        'client_ur_ls' => null,
        'ping_frequency' => null,
        'ping_url' => null,
        'recipient_id' => null,
        'return_url' => null,
        'security_domain' => null,
        'x_frame_options' => null,
        'x_frame_options_allow_from_url' => null
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
        'assertion_id' => 'assertionId',
        'authentication_instant' => 'authenticationInstant',
        'authentication_method' => 'authenticationMethod',
        'client_ur_ls' => 'clientURLs',
        'ping_frequency' => 'pingFrequency',
        'ping_url' => 'pingUrl',
        'recipient_id' => 'recipientId',
        'return_url' => 'returnUrl',
        'security_domain' => 'securityDomain',
        'x_frame_options' => 'xFrameOptions',
        'x_frame_options_allow_from_url' => 'xFrameOptionsAllowFromUrl'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'assertion_id' => 'setAssertionId',
        'authentication_instant' => 'setAuthenticationInstant',
        'authentication_method' => 'setAuthenticationMethod',
        'client_ur_ls' => 'setClientUrLs',
        'ping_frequency' => 'setPingFrequency',
        'ping_url' => 'setPingUrl',
        'recipient_id' => 'setRecipientId',
        'return_url' => 'setReturnUrl',
        'security_domain' => 'setSecurityDomain',
        'x_frame_options' => 'setXFrameOptions',
        'x_frame_options_allow_from_url' => 'setXFrameOptionsAllowFromUrl'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'assertion_id' => 'getAssertionId',
        'authentication_instant' => 'getAuthenticationInstant',
        'authentication_method' => 'getAuthenticationMethod',
        'client_ur_ls' => 'getClientUrLs',
        'ping_frequency' => 'getPingFrequency',
        'ping_url' => 'getPingUrl',
        'recipient_id' => 'getRecipientId',
        'return_url' => 'getReturnUrl',
        'security_domain' => 'getSecurityDomain',
        'x_frame_options' => 'getXFrameOptions',
        'x_frame_options_allow_from_url' => 'getXFrameOptionsAllowFromUrl'
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
        $this->container['assertion_id'] = isset($data['assertion_id']) ? $data['assertion_id'] : null;
        $this->container['authentication_instant'] = isset($data['authentication_instant']) ? $data['authentication_instant'] : null;
        $this->container['authentication_method'] = isset($data['authentication_method']) ? $data['authentication_method'] : null;
        $this->container['client_ur_ls'] = isset($data['client_ur_ls']) ? $data['client_ur_ls'] : null;
        $this->container['ping_frequency'] = isset($data['ping_frequency']) ? $data['ping_frequency'] : null;
        $this->container['ping_url'] = isset($data['ping_url']) ? $data['ping_url'] : null;
        $this->container['recipient_id'] = isset($data['recipient_id']) ? $data['recipient_id'] : null;
        $this->container['return_url'] = isset($data['return_url']) ? $data['return_url'] : null;
        $this->container['security_domain'] = isset($data['security_domain']) ? $data['security_domain'] : null;
        $this->container['x_frame_options'] = isset($data['x_frame_options']) ? $data['x_frame_options'] : null;
        $this->container['x_frame_options_allow_from_url'] = isset($data['x_frame_options_allow_from_url']) ? $data['x_frame_options_allow_from_url'] : null;
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
     * Gets assertion_id
     *
     * @return ?string
     */
    public function getAssertionId()
    {
        return $this->container['assertion_id'];
    }

    /**
     * Sets assertion_id
     *
     * @param ?string $assertion_id 
     *
     * @return $this
     */
    public function setAssertionId($assertion_id)
    {
        $this->container['assertion_id'] = $assertion_id;

        return $this;
    }

    /**
     * Gets authentication_instant
     *
     * @return ?string
     */
    public function getAuthenticationInstant()
    {
        return $this->container['authentication_instant'];
    }

    /**
     * Sets authentication_instant
     *
     * @param ?string $authentication_instant 
     *
     * @return $this
     */
    public function setAuthenticationInstant($authentication_instant)
    {
        $this->container['authentication_instant'] = $authentication_instant;

        return $this;
    }

    /**
     * Gets authentication_method
     *
     * @return ?string
     */
    public function getAuthenticationMethod()
    {
        return $this->container['authentication_method'];
    }

    /**
     * Sets authentication_method
     *
     * @param ?string $authentication_method 
     *
     * @return $this
     */
    public function setAuthenticationMethod($authentication_method)
    {
        $this->container['authentication_method'] = $authentication_method;

        return $this;
    }

    /**
     * Gets client_ur_ls
     *
     * @return \DocuSign\eSign\Model\RecipientTokenClientURLs
     */
    public function getClientUrLs()
    {
        return $this->container['client_ur_ls'];
    }

    /**
     * Sets client_ur_ls
     *
     * @param \DocuSign\eSign\Model\RecipientTokenClientURLs $client_ur_ls 
     *
     * @return $this
     */
    public function setClientUrLs($client_ur_ls)
    {
        $this->container['client_ur_ls'] = $client_ur_ls;

        return $this;
    }

    /**
     * Gets ping_frequency
     *
     * @return ?string
     */
    public function getPingFrequency()
    {
        return $this->container['ping_frequency'];
    }

    /**
     * Sets ping_frequency
     *
     * @param ?string $ping_frequency 
     *
     * @return $this
     */
    public function setPingFrequency($ping_frequency)
    {
        $this->container['ping_frequency'] = $ping_frequency;

        return $this;
    }

    /**
     * Gets ping_url
     *
     * @return ?string
     */
    public function getPingUrl()
    {
        return $this->container['ping_url'];
    }

    /**
     * Sets ping_url
     *
     * @param ?string $ping_url 
     *
     * @return $this
     */
    public function setPingUrl($ping_url)
    {
        $this->container['ping_url'] = $ping_url;

        return $this;
    }

    /**
     * Gets recipient_id
     *
     * @return ?string
     */
    public function getRecipientId()
    {
        return $this->container['recipient_id'];
    }

    /**
     * Sets recipient_id
     *
     * @param ?string $recipient_id Unique for the recipient. It is used by the tab element to indicate which recipient is to sign the Document.
     *
     * @return $this
     */
    public function setRecipientId($recipient_id)
    {
        $this->container['recipient_id'] = $recipient_id;

        return $this;
    }

    /**
     * Gets return_url
     *
     * @return ?string
     */
    public function getReturnUrl()
    {
        return $this->container['return_url'];
    }

    /**
     * Sets return_url
     *
     * @param ?string $return_url 
     *
     * @return $this
     */
    public function setReturnUrl($return_url)
    {
        $this->container['return_url'] = $return_url;

        return $this;
    }

    /**
     * Gets security_domain
     *
     * @return ?string
     */
    public function getSecurityDomain()
    {
        return $this->container['security_domain'];
    }

    /**
     * Sets security_domain
     *
     * @param ?string $security_domain 
     *
     * @return $this
     */
    public function setSecurityDomain($security_domain)
    {
        $this->container['security_domain'] = $security_domain;

        return $this;
    }

    /**
     * Gets x_frame_options
     *
     * @return ?string
     */
    public function getXFrameOptions()
    {
        return $this->container['x_frame_options'];
    }

    /**
     * Sets x_frame_options
     *
     * @param ?string $x_frame_options 
     *
     * @return $this
     */
    public function setXFrameOptions($x_frame_options)
    {
        $this->container['x_frame_options'] = $x_frame_options;

        return $this;
    }

    /**
     * Gets x_frame_options_allow_from_url
     *
     * @return ?string
     */
    public function getXFrameOptionsAllowFromUrl()
    {
        return $this->container['x_frame_options_allow_from_url'];
    }

    /**
     * Sets x_frame_options_allow_from_url
     *
     * @param ?string $x_frame_options_allow_from_url 
     *
     * @return $this
     */
    public function setXFrameOptionsAllowFromUrl($x_frame_options_allow_from_url)
    {
        $this->container['x_frame_options_allow_from_url'] = $x_frame_options_allow_from_url;

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

