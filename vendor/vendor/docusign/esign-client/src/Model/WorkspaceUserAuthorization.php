<?php
/**
 * WorkspaceUserAuthorization
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
 * WorkspaceUserAuthorization Class Doc Comment
 *
 * @category    Class
 * @description Provides properties that describe user authorization to a workspace.
 * @package     DocuSign\eSign
 * @author      Swagger Codegen team <apihelp@docusign.com>
 * @license     The Docusign PHP Client SDK is licensed under the MIT License.
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class WorkspaceUserAuthorization implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'workspaceUserAuthorization';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'can_delete' => '?string',
        'can_move' => '?string',
        'can_transact' => '?string',
        'can_view' => '?string',
        'created' => '?string',
        'created_by_id' => '?string',
        'error_details' => '\DocuSign\eSign\Model\ErrorDetails',
        'modified' => '?string',
        'modified_by_id' => '?string',
        'workspace_user_id' => '?string',
        'workspace_user_information' => '\DocuSign\eSign\Model\WorkspaceUser'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'can_delete' => null,
        'can_move' => null,
        'can_transact' => null,
        'can_view' => null,
        'created' => null,
        'created_by_id' => null,
        'error_details' => null,
        'modified' => null,
        'modified_by_id' => null,
        'workspace_user_id' => null,
        'workspace_user_information' => null
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
        'can_delete' => 'canDelete',
        'can_move' => 'canMove',
        'can_transact' => 'canTransact',
        'can_view' => 'canView',
        'created' => 'created',
        'created_by_id' => 'createdById',
        'error_details' => 'errorDetails',
        'modified' => 'modified',
        'modified_by_id' => 'modifiedById',
        'workspace_user_id' => 'workspaceUserId',
        'workspace_user_information' => 'workspaceUserInformation'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'can_delete' => 'setCanDelete',
        'can_move' => 'setCanMove',
        'can_transact' => 'setCanTransact',
        'can_view' => 'setCanView',
        'created' => 'setCreated',
        'created_by_id' => 'setCreatedById',
        'error_details' => 'setErrorDetails',
        'modified' => 'setModified',
        'modified_by_id' => 'setModifiedById',
        'workspace_user_id' => 'setWorkspaceUserId',
        'workspace_user_information' => 'setWorkspaceUserInformation'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'can_delete' => 'getCanDelete',
        'can_move' => 'getCanMove',
        'can_transact' => 'getCanTransact',
        'can_view' => 'getCanView',
        'created' => 'getCreated',
        'created_by_id' => 'getCreatedById',
        'error_details' => 'getErrorDetails',
        'modified' => 'getModified',
        'modified_by_id' => 'getModifiedById',
        'workspace_user_id' => 'getWorkspaceUserId',
        'workspace_user_information' => 'getWorkspaceUserInformation'
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
        $this->container['can_delete'] = isset($data['can_delete']) ? $data['can_delete'] : null;
        $this->container['can_move'] = isset($data['can_move']) ? $data['can_move'] : null;
        $this->container['can_transact'] = isset($data['can_transact']) ? $data['can_transact'] : null;
        $this->container['can_view'] = isset($data['can_view']) ? $data['can_view'] : null;
        $this->container['created'] = isset($data['created']) ? $data['created'] : null;
        $this->container['created_by_id'] = isset($data['created_by_id']) ? $data['created_by_id'] : null;
        $this->container['error_details'] = isset($data['error_details']) ? $data['error_details'] : null;
        $this->container['modified'] = isset($data['modified']) ? $data['modified'] : null;
        $this->container['modified_by_id'] = isset($data['modified_by_id']) ? $data['modified_by_id'] : null;
        $this->container['workspace_user_id'] = isset($data['workspace_user_id']) ? $data['workspace_user_id'] : null;
        $this->container['workspace_user_information'] = isset($data['workspace_user_information']) ? $data['workspace_user_information'] : null;
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
     * Gets can_delete
     *
     * @return ?string
     */
    public function getCanDelete()
    {
        return $this->container['can_delete'];
    }

    /**
     * Sets can_delete
     *
     * @param ?string $can_delete 
     *
     * @return $this
     */
    public function setCanDelete($can_delete)
    {
        $this->container['can_delete'] = $can_delete;

        return $this;
    }

    /**
     * Gets can_move
     *
     * @return ?string
     */
    public function getCanMove()
    {
        return $this->container['can_move'];
    }

    /**
     * Sets can_move
     *
     * @param ?string $can_move 
     *
     * @return $this
     */
    public function setCanMove($can_move)
    {
        $this->container['can_move'] = $can_move;

        return $this;
    }

    /**
     * Gets can_transact
     *
     * @return ?string
     */
    public function getCanTransact()
    {
        return $this->container['can_transact'];
    }

    /**
     * Sets can_transact
     *
     * @param ?string $can_transact 
     *
     * @return $this
     */
    public function setCanTransact($can_transact)
    {
        $this->container['can_transact'] = $can_transact;

        return $this;
    }

    /**
     * Gets can_view
     *
     * @return ?string
     */
    public function getCanView()
    {
        return $this->container['can_view'];
    }

    /**
     * Sets can_view
     *
     * @param ?string $can_view 
     *
     * @return $this
     */
    public function setCanView($can_view)
    {
        $this->container['can_view'] = $can_view;

        return $this;
    }

    /**
     * Gets created
     *
     * @return ?string
     */
    public function getCreated()
    {
        return $this->container['created'];
    }

    /**
     * Sets created
     *
     * @param ?string $created The UTC DateTime when the workspace user authorization was created.
     *
     * @return $this
     */
    public function setCreated($created)
    {
        $this->container['created'] = $created;

        return $this;
    }

    /**
     * Gets created_by_id
     *
     * @return ?string
     */
    public function getCreatedById()
    {
        return $this->container['created_by_id'];
    }

    /**
     * Sets created_by_id
     *
     * @param ?string $created_by_id 
     *
     * @return $this
     */
    public function setCreatedById($created_by_id)
    {
        $this->container['created_by_id'] = $created_by_id;

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
     * Gets modified
     *
     * @return ?string
     */
    public function getModified()
    {
        return $this->container['modified'];
    }

    /**
     * Sets modified
     *
     * @param ?string $modified 
     *
     * @return $this
     */
    public function setModified($modified)
    {
        $this->container['modified'] = $modified;

        return $this;
    }

    /**
     * Gets modified_by_id
     *
     * @return ?string
     */
    public function getModifiedById()
    {
        return $this->container['modified_by_id'];
    }

    /**
     * Sets modified_by_id
     *
     * @param ?string $modified_by_id 
     *
     * @return $this
     */
    public function setModifiedById($modified_by_id)
    {
        $this->container['modified_by_id'] = $modified_by_id;

        return $this;
    }

    /**
     * Gets workspace_user_id
     *
     * @return ?string
     */
    public function getWorkspaceUserId()
    {
        return $this->container['workspace_user_id'];
    }

    /**
     * Sets workspace_user_id
     *
     * @param ?string $workspace_user_id 
     *
     * @return $this
     */
    public function setWorkspaceUserId($workspace_user_id)
    {
        $this->container['workspace_user_id'] = $workspace_user_id;

        return $this;
    }

    /**
     * Gets workspace_user_information
     *
     * @return \DocuSign\eSign\Model\WorkspaceUser
     */
    public function getWorkspaceUserInformation()
    {
        return $this->container['workspace_user_information'];
    }

    /**
     * Sets workspace_user_information
     *
     * @param \DocuSign\eSign\Model\WorkspaceUser $workspace_user_information An object that provides details about the workspace user.
     *
     * @return $this
     */
    public function setWorkspaceUserInformation($workspace_user_information)
    {
        $this->container['workspace_user_information'] = $workspace_user_information;

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

