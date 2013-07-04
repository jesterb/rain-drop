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
  
  private static $config;

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
}
