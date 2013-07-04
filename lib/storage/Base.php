<?php

namespace RainDrop\Storage;

abstract class Base
{
  const OPT_NAMESPACE = 'raindrop_';
  
  private $host, $user, $pass;

  /**
   * 
   * @param string $host
   * @param string $user
   * @param string $pass
   */
  public function __construct($host = null, $user = null, $pass = null)
  {
    $this->host = $host;
    $this->user = $user;
    $this->pass = $pass;
    $this->init();
  }
  
  /**
   * Init anything need for storage
   */
  protected function init() {}
  
  /**
   * 
   * @param string $key
   */
  abstract public function get($key);
  
  /**
   * 
   * @param string $key
   * @param mixed $val
   */
  abstract public function set($key, $val);

  /**
   * 
   * @return string
   */
  protected function getHost()
  {
    return $this->host;
  }
  
  /**
   * 
   * @return string
   */
  protected function getUser()
  {
    return $this->user;
  }
  
  /**
   * 
   * @return string
   */
  protected function getPass()
  {
    return $this->pass;
  }
}
