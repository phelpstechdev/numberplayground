<?php
/**
 * District
 *
 * PHP version 5
 *
 * @category Class
 * @package  Clever
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * Clever API
 *
 * The Clever API
 *
 * OpenAPI spec version: 2.0.0
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Clever\Model;

use \ArrayAccess;
use \Clever\ObjectSerializer;

/**
 * District Class Doc Comment
 *
 * @category Class
 * @package  Clever
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class District implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'District';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'error' => 'string',
        'id' => 'string',
        'last_sync' => 'string',
        'launch_date' => 'string',
        'mdr_number' => 'string',
        'name' => 'string',
        'nces_id' => 'string',
        'pause_end' => 'string',
        'pause_start' => 'string',
        'sis_type' => 'string',
        'state' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'error' => null,
        'id' => null,
        'last_sync' => 'datetime',
        'launch_date' => 'datetime',
        'mdr_number' => null,
        'name' => null,
        'nces_id' => null,
        'pause_end' => 'datetime',
        'pause_start' => 'datetime',
        'sis_type' => null,
        'state' => null
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
        'error' => 'error',
        'id' => 'id',
        'last_sync' => 'last_sync',
        'launch_date' => 'launch_date',
        'mdr_number' => 'mdr_number',
        'name' => 'name',
        'nces_id' => 'nces_id',
        'pause_end' => 'pause_end',
        'pause_start' => 'pause_start',
        'sis_type' => 'sis_type',
        'state' => 'state'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'error' => 'setError',
        'id' => 'setId',
        'last_sync' => 'setLastSync',
        'launch_date' => 'setLaunchDate',
        'mdr_number' => 'setMdrNumber',
        'name' => 'setName',
        'nces_id' => 'setNcesId',
        'pause_end' => 'setPauseEnd',
        'pause_start' => 'setPauseStart',
        'sis_type' => 'setSisType',
        'state' => 'setState'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'error' => 'getError',
        'id' => 'getId',
        'last_sync' => 'getLastSync',
        'launch_date' => 'getLaunchDate',
        'mdr_number' => 'getMdrNumber',
        'name' => 'getName',
        'nces_id' => 'getNcesId',
        'pause_end' => 'getPauseEnd',
        'pause_start' => 'getPauseStart',
        'sis_type' => 'getSisType',
        'state' => 'getState'
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

    const STATE_RUNNING = 'running';
    const STATE_PENDING = 'pending';
    const STATE_ERROR = 'error';
    const STATE_PAUSED = 'paused';
    

    
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getStateAllowableValues()
    {
        return [
            self::STATE_RUNNING,
            self::STATE_PENDING,
            self::STATE_ERROR,
            self::STATE_PAUSED,
        ];
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
        $this->container['error'] = isset($data['error']) ? $data['error'] : null;
        $this->container['id'] = isset($data['id']) ? $data['id'] : null;
        $this->container['last_sync'] = isset($data['last_sync']) ? $data['last_sync'] : null;
        $this->container['launch_date'] = isset($data['launch_date']) ? $data['launch_date'] : null;
        $this->container['mdr_number'] = isset($data['mdr_number']) ? $data['mdr_number'] : null;
        $this->container['name'] = isset($data['name']) ? $data['name'] : null;
        $this->container['nces_id'] = isset($data['nces_id']) ? $data['nces_id'] : null;
        $this->container['pause_end'] = isset($data['pause_end']) ? $data['pause_end'] : null;
        $this->container['pause_start'] = isset($data['pause_start']) ? $data['pause_start'] : null;
        $this->container['sis_type'] = isset($data['sis_type']) ? $data['sis_type'] : null;
        $this->container['state'] = isset($data['state']) ? $data['state'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        $allowedValues = $this->getStateAllowableValues();
        if (!in_array($this->container['state'], $allowedValues)) {
            $invalidProperties[] = sprintf(
                "invalid value for 'state', must be one of '%s'",
                implode("', '", $allowedValues)
            );
        }

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

        $allowedValues = $this->getStateAllowableValues();
        if (!in_array($this->container['state'], $allowedValues)) {
            return false;
        }
        return true;
    }


    /**
     * Gets error
     *
     * @return string
     */
    public function getError()
    {
        return $this->container['error'];
    }

    /**
     * Sets error
     *
     * @param string $error error
     *
     * @return $this
     */
    public function setError($error)
    {
        $this->container['error'] = $error;

        return $this;
    }

    /**
     * Gets id
     *
     * @return string
     */
    public function getId()
    {
        return $this->container['id'];
    }

    /**
     * Sets id
     *
     * @param string $id id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->container['id'] = $id;

        return $this;
    }

    /**
     * Gets last_sync
     *
     * @return string
     */
    public function getLastSync()
    {
        return $this->container['last_sync'];
    }

    /**
     * Sets last_sync
     *
     * @param string $last_sync last_sync
     *
     * @return $this
     */
    public function setLastSync($last_sync)
    {
        $this->container['last_sync'] = $last_sync;

        return $this;
    }

    /**
     * Gets launch_date
     *
     * @return string
     */
    public function getLaunchDate()
    {
        return $this->container['launch_date'];
    }

    /**
     * Sets launch_date
     *
     * @param string $launch_date launch_date
     *
     * @return $this
     */
    public function setLaunchDate($launch_date)
    {
        $this->container['launch_date'] = $launch_date;

        return $this;
    }

    /**
     * Gets mdr_number
     *
     * @return string
     */
    public function getMdrNumber()
    {
        return $this->container['mdr_number'];
    }

    /**
     * Sets mdr_number
     *
     * @param string $mdr_number mdr_number
     *
     * @return $this
     */
    public function setMdrNumber($mdr_number)
    {
        $this->container['mdr_number'] = $mdr_number;

        return $this;
    }

    /**
     * Gets name
     *
     * @return string
     */
    public function getName()
    {
        return $this->container['name'];
    }

    /**
     * Sets name
     *
     * @param string $name name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->container['name'] = $name;

        return $this;
    }

    /**
     * Gets nces_id
     *
     * @return string
     */
    public function getNcesId()
    {
        return $this->container['nces_id'];
    }

    /**
     * Sets nces_id
     *
     * @param string $nces_id nces_id
     *
     * @return $this
     */
    public function setNcesId($nces_id)
    {
        $this->container['nces_id'] = $nces_id;

        return $this;
    }

    /**
     * Gets pause_end
     *
     * @return string
     */
    public function getPauseEnd()
    {
        return $this->container['pause_end'];
    }

    /**
     * Sets pause_end
     *
     * @param string $pause_end pause_end
     *
     * @return $this
     */
    public function setPauseEnd($pause_end)
    {
        $this->container['pause_end'] = $pause_end;

        return $this;
    }

    /**
     * Gets pause_start
     *
     * @return string
     */
    public function getPauseStart()
    {
        return $this->container['pause_start'];
    }

    /**
     * Sets pause_start
     *
     * @param string $pause_start pause_start
     *
     * @return $this
     */
    public function setPauseStart($pause_start)
    {
        $this->container['pause_start'] = $pause_start;

        return $this;
    }

    /**
     * Gets sis_type
     *
     * @return string
     */
    public function getSisType()
    {
        return $this->container['sis_type'];
    }

    /**
     * Sets sis_type
     *
     * @param string $sis_type sis_type
     *
     * @return $this
     */
    public function setSisType($sis_type)
    {
        $this->container['sis_type'] = $sis_type;

        return $this;
    }

    /**
     * Gets state
     *
     * @return string
     */
    public function getState()
    {
        return $this->container['state'];
    }

    /**
     * Sets state
     *
     * @param string $state state
     *
     * @return $this
     */
    public function setState($state)
    {
        $allowedValues = $this->getStateAllowableValues();
        if (!is_null($state) && !in_array($state, $allowedValues)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value for 'state', must be one of '%s'",
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['state'] = $state;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
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


