<?php

/**
 * Namespace for RainDrop api request
 */
namespace RainDrop\Api\Request;

/**
 * Base class that api requests should inherit
 */
abstract class Base
{
  const RESP_RSS = 0;
  const RESP_XML = 1;
  
  const UNIT_US = 0;
  const RESP_METRIC = 1;
  
  const PARAM_OUTPUT_TYPE = 'OutputType';
  const PARAM_UNIT_TYPE = 'UnitType';
  
  private $params = array();
  
  /**
   * Sets defaults of XML and US units
   */
  public function __construct()
  {
    $this->setResponseType(self::RESP_XML);
    $this->setUnitType(self::UNIT_US);
  }
  
  /**
   * 
   * @return string
   */
  abstract public function getUrl();
  
  /**
   * 
   * @param string $param
   * @param mixed $value
   * @return Base
   */
  protected function setParam($param, $value)
  {
    $this->params[$param] = $value;
    return $this;
  }
  
  /**
   * 
   * @return string[]
   */
  public function getParams()
  {
    return $this->params;
  }
  
  /**
   * 
   * @param string $type
   * @return Base
   */
  public function setResponseType($type)
  {
    $this->setParam(self::PARAM_OUTPUT_TYPE, $type);
    return $this;
  }
  
  /**
   * 
   * @param string $type
   * @return Base
   */
  public function setUnitType($type)
  {
    $this->setParam(self::PARAM_UNIT_TYPE, $type);
    return $this;
  }
}
