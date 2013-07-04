<?php

/**
 * Namespace for RainDrop api request
 */
namespace RainDrop\Api\Request;

/**
 * LiveWeather request class
 */
class LiveWeather extends Base
{
  const LOC_STATION = 'stationId';
  const LOC_ZIPCODE = 'zipCode';
  const LOC_CITY = 'cityCode';
  const LOC_LAT = 'lat';
  const LOC_LONG = 'long';
  
  const URL = 'https://thepulseapi.earthnetworks.com/getLiveWeatherRSS.aspx';
  
  private $locType = null;
  private $locData = null;
  
  /**
   * 
   * @return string
   */
  public function getUrl()
  {
    return self::URL;
  }
  
  /**
   * 
   * @return string[]
   */
  public function getParams()
  {
    if (!is_array($this->locType))
    {
      $this->locType = array($this->locType);
    }
    
    if (!is_array($this->locData))
    {
      $this->locData = array($this->locData);
    }
    
    // Add params for the location type 
    foreach ($this->locType as $i => $param)
    {
      $this->setParam($param, $this->locData[$i]);
    }
    
    return parent::getParams();
  }
  
  /**
   * 
   * @param type $zip
   */
  public function setStationId($id)
  {
    $this->setLocData(self::LOC_STATION, $id);
  }
  
  /**
   * 
   * @param type $zip
   */
  public function setZipcode($zip)
  {
    $this->setLocData(self::LOC_ZIPCODE, $zip);
  }
  
  /**
   * 
   * @param type $city
   */
  public function setCityCode($code)
  {
    $this->setLocData(self::LOC_CITY, $code);
  }
  
  /**
   * 
   * @param float $lat
   * @param float $long
   */
  public function setLatLong($lat, $long)
  {
    $this->setLocData(array(self::LOC_LAT, self::LOC_LONG), array($lat, $long));
  }
  
  /**
   * Set the location search type and data
   * 
   * @param type $loc
   * @param type $data
   */
  private function setLocData($loc, $data)
  {
    $this->locType = $loc;
    $this->locData = $data;
  }
}
