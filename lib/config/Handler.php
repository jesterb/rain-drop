<?php

/**
 * The namespace for the RainDrop config classes
 */
namespace RainDrop\Config;

/**
 * Config file handler
 */
class Handler
{
  const SECTION_CORE = 'core';
  const SECTION_STORAGE = 'storage';
  
  const OPT_CLIENT_ID = 'consumer_key';
  const OPT_CLIENT_SECRET = 'consumer_secret_key';
  const OPT_CLASS = 'class';
  const OPT_HOST= 'host';
  const OPT_USER = 'user';
  const OPT_PASS = 'pass';
  
  private $data;
  private $file;
  
  /**
   * 
   * @param type $file
   */
  public function __construct($file)
  {
    $this->file = $file;
    $this->data = $this->read($file);
  }
  
  /**
   * 
   * @param string $file
   * @return string[]
   */
  protected function read($file)
  {
    return parse_ini_file($file, true);
  }
  
  /**
   * 
   * @param string $key
   * @param string $section
   * @return mixed|null
   */
  public function get($key, $section = self::SECTION_CORE)
  {
    if (empty($this->data[$section]) || empty($this->data[$section][$key]))
    {
      return null;
    }
    
    return $this->data[$section][$key];
  }
}
