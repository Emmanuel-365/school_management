<?php
/**
 * RecipientEmailNotification
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
 * RecipientEmailNotification Class Doc Comment
 *
 * @category    Class
 * @package     DocuSign\eSign
 * @author      Swagger Codegen team <apihelp@docusign.com>
 * @license     The Docusign PHP Client SDK is licensed under the MIT License.
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class RecipientEmailNotification implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'recipientEmailNotification';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'email_body' => '?string',
        'email_body_metadata' => '\DocuSign\eSign\Model\PropertyMetadata',
        'email_subject' => '?string',
        'email_subject_metadata' => '\DocuSign\eSign\Model\PropertyMetadata',
        'supported_language' => '?string',
        'supported_language_metadata' => '\DocuSign\eSign\Model\PropertyMetadata'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'email_body' => null,
        'email_body_metadata' => null,
        'email_subject' => null,
        'email_subject_metadata' => null,
        'supported_language' => null,
        'supported_language_metadata' => null
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
        'email_body' => 'emailBody',
        'email_body_metadata' => 'emailBodyMetadata',
        'email_subject' => 'emailSubject',
        'email_subject_metadata' => 'emailSubjectMetadata',
        'supported_language' => 'supportedLanguage',
        'supported_language_metadata' => 'supportedLanguageMetadata'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'email_body' => 'setEmailBody',
        'email_body_metadata' => 'setEmailBodyMetadata',
        'email_subject' => 'setEmailSubject',
        'email_subject_metadata' => 'setEmailSubjectMetadata',
        'supported_language' => 'setSupportedLanguage',
        'supported_language_metadata' => 'setSupportedLanguageMetadata'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'email_body' => 'getEmailBody',
        'email_body_metadata' => 'getEmailBodyMetadata',
        'email_subject' => 'getEmailSubject',
        'email_subject_metadata' => 'getEmailSubjectMetadata',
        'supported_language' => 'getSupportedLanguage',
        'supported_language_metadata' => 'getSupportedLanguageMetadata'
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
        $this->container['email_body'] = isset($data['email_body']) ? $data['email_body'] : null;
        $this->container['email_body_metadata'] = isset($data['email_body_metadata']) ? $data['email_body_metadata'] : null;
        $this->container['email_subject'] = isset($data['email_subject']) ? $data['email_subject'] : null;
        $this->container['email_subject_metadata'] = isset($data['email_subject_metadata']) ? $data['email_subject_metadata'] : null;
        $this->container['supported_language'] = isset($data['supported_language']) ? $data['supported_language'] : null;
        $this->container['supported_language_metadata'] = isset($data['supported_language_metadata']) ? $data['supported_language_metadata'] : null;
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
     * Gets email_body
     *
     * @return ?string
     */
    public function getEmailBody()
    {
        return $this->container['email_body'];
    }

    /**
     * Sets email_body
     *
     * @param ?string $email_body Specifies the email body of the message sent to the recipient.   Maximum length: 10000 characters.
     *
     * @return $this
     */
    public function setEmailBody($email_body)
    {
        $this->container['email_body'] = $email_body;

        return $this;
    }

    /**
     * Gets email_body_metadata
     *
     * @return \DocuSign\eSign\Model\PropertyMetadata
     */
    public function getEmailBodyMetadata()
    {
        return $this->container['email_body_metadata'];
    }

    /**
     * Sets email_body_metadata
     *
     * @param \DocuSign\eSign\Model\PropertyMetadata $email_body_metadata Metadata that indicates whether the `emailBody` property can be edited.
     *
     * @return $this
     */
    public function setEmailBodyMetadata($email_body_metadata)
    {
        $this->container['email_body_metadata'] = $email_body_metadata;

        return $this;
    }

    /**
     * Gets email_subject
     *
     * @return ?string
     */
    public function getEmailSubject()
    {
        return $this->container['email_subject'];
    }

    /**
     * Sets email_subject
     *
     * @param ?string $email_subject Specifies the subject of the email that is sent to all recipients.  See [ML:Template Email Subject Merge Fields] for information about adding merge field information to the email subject.
     *
     * @return $this
     */
    public function setEmailSubject($email_subject)
    {
        $this->container['email_subject'] = $email_subject;

        return $this;
    }

    /**
     * Gets email_subject_metadata
     *
     * @return \DocuSign\eSign\Model\PropertyMetadata
     */
    public function getEmailSubjectMetadata()
    {
        return $this->container['email_subject_metadata'];
    }

    /**
     * Sets email_subject_metadata
     *
     * @param \DocuSign\eSign\Model\PropertyMetadata $email_subject_metadata Metadata that indicates whether the `emailSubject` property can be edited.
     *
     * @return $this
     */
    public function setEmailSubjectMetadata($email_subject_metadata)
    {
        $this->container['email_subject_metadata'] = $email_subject_metadata;

        return $this;
    }

    /**
     * Gets supported_language
     *
     * @return ?string
     */
    public function getSupportedLanguage()
    {
        return $this->container['supported_language'];
    }

    /**
     * Sets supported_language
     *
     * @param ?string $supported_language A simple type enumeration of the language used. The supported languages, with the language value shown in parenthesis, are: Arabic (ar), Armenian (hy), Bahasa Indonesia (id), Bahasa Melayu (ms) Bulgarian (bg), Czech (cs), Chinese Simplified (zh_CN), Chinese Traditional (zh_TW), Croatian (hr), Danish (da), Dutch (nl), English US (en), English UK (en_GB), Estonian (et), Farsi (fa), Finnish (fi), French (fr), French Canada (fr_CA), German (de), Greek (el), Hebrew (he), Hindi (hi), Hungarian (hu), Italian (it), Japanese (ja), Korean (ko), Latvian (lv), Lithuanian (lt), Norwegian (no), Polish (pl), Portuguese (pt), Portuguese Brazil (pt_BR), Romanian (ro),Russian (ru), Serbian (sr), Slovak (sk), Slovenian (sl), Spanish (es),Spanish Latin America (es_MX), Swedish (sv), Thai (th), Turkish (tr), Ukrainian (uk), and Vietnamese (vi).
     *
     * @return $this
     */
    public function setSupportedLanguage($supported_language)
    {
        $this->container['supported_language'] = $supported_language;

        return $this;
    }

    /**
     * Gets supported_language_metadata
     *
     * @return \DocuSign\eSign\Model\PropertyMetadata
     */
    public function getSupportedLanguageMetadata()
    {
        return $this->container['supported_language_metadata'];
    }

    /**
     * Sets supported_language_metadata
     *
     * @param \DocuSign\eSign\Model\PropertyMetadata $supported_language_metadata Metadata that indicates whether the `supportedLanguage` property can be edited.
     *
     * @return $this
     */
    public function setSupportedLanguageMetadata($supported_language_metadata)
    {
        $this->container['supported_language_metadata'] = $supported_language_metadata;

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

