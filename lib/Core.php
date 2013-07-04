<?php

/**
 * The namespace for the RainDrop classes
 */
namespace RainDrop;

/**
 * Core class
 */
class Core
{
  const CONFIG_FILE = 'config.ini';
  
  private static $config, $client, $storage;

  /**
   * 
   */
  public static function init($root)
  {
    self::$config = new Config\Handler("$root/" . self::CONFIG_FILE);
  }
  
  /**
   * 
   * @return Config\Handler
   */
  public static function getConfigHandler()
  {
    return self::$config;
  }
  
  /**
   * 
   * @return \RainDrop\Api\Client
   */
  public static function getClient()
  {
    if (!empty(self::$client))
    {
      return self::$client;
    }
    
    $handler = self::getConfigHandler();
    $clientId = $handler->get(Config\Handler::OPT_CLIENT_ID);
    $clientSecret = $handler->get(Config\Handler::OPT_CLIENT_SECRET);
    
    return self::$client = new Api\Client($clientId, $clientSecret, 
      self::getStorage());
  }
  
  /**
   * 
   * @return \RainDrop\Storage\Base
   * @throws \Exception
   */
  public static function getStorage()
  {
    if (!empty(self::$storage))
    {
      return self::$storage;
    }
    
    $handler = self::getConfigHandler();
    
    $class = $handler->get(Config\Handler::OPT_CLASS, 
      Config\Handler::SECTION_STORAGE);
    
    if (empty($class))
    {
      return null;
    }
    
    $fullClass = "\\RainDrop\\Storage\\$class";
    
    if (!class_exists($fullClass))
    {
      throw new \Exception("Unable to load storage class '$fullClass'");
    }
    
    $host = $handler->get(Config\Handler::OPT_HOST, 
      Config\Handler::SECTION_STORAGE);
    $user = $handler->get(Config\Handler::OPT_USER, 
      Config\Handler::SECTION_STORAGE);
    $pass = $handler->get(Config\Handler::OPT_PASS, 
      Config\Handler::SECTION_STORAGE);
    
    return self::$storage = new $fullClass($host, $user, $pass);
  }
}
