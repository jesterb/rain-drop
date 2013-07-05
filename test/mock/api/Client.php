<?php

/**
 * The mock namespace
 */
namespace RainDrop\Test\Mock\Api;

/**
 * Mock Api Client 
 */
class Client extends \RainDrop\Api\Client
{
  const CLIENT_ID = 'test_12345';
  const CLIENT_SECRET = 'test_abcdefg';
  
  private $tokenResp, $execResp, $tokenLoad, $url, $params;
  
  public function __construct($tokenResp, $execResp, $storage = null)
  {
    $this->tokenResp = $tokenResp;
    $this->execResp = $execResp;
    
    parent::__construct(self::CLIENT_ID, self::CLIENT_SECRET, $storage);
  }
  
  protected function doExecute($url, $params)
  {
    $this->url = $url;
    $this->params = $params;
    
    if ($this->tokenLoad)
    {
      $this->tokenLoad = false;
      return $this->tokenResp;
    }
    
    return $this->execResp;
  }

  protected function loadToken($clientId, $clientSecret, &$expire = null)
  {
    $this->tokenLoad = true;
    return parent::loadToken($clientId, $clientSecret, $expire);
  }
  
  public function getUrl()
  {
    return $this->url;
  }
  
  public function getParams()
  {
    return $this->params;
  }
  
  public function getToken()
  {
    return parent::getToken();
  }
}
