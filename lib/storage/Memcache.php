<?php

/**
 * Storage namespace
 */
namespace RainDrop\Storage;

/**
 * Memcache storage handler class
 */
class Memcache extends Base
{
  private $rs;

  protected function init()
  {
    parent::init();
    
    $rs = new \Memcache();
    
    $host = $this->getHost();
    
    if (!empty($host))
    {
      $rs->connect($this->getHost());
    }
    
    $this->rs = $rs;
  }
  
  /**
   * 
   * @param string $key
   * @param mixed $val
   * @return bool 
   */
  public function set($key, $val, $expire = 0)
  {
    return $this->getResource()->set(self::OPT_NAMESPACE . $key, $val, 0, $expire);
  }
  
  /**
   * 
   * @param string $key
   * @return mixed
   */
  public function get($key)
  {
    return $this->getResource()->get(self::OPT_NAMESPACE . $key);
  }
  
  /**
   * 
   * @return \Memcache
   */
  private function getResource()
  {
    return $this->rs;
  }
}
