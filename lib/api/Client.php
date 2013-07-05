<?php

/**
 * RainDrop API namespace
 */
namespace RainDrop\Api;

/**
 * The API client
 */
class Client
{
  const PARAM_ACCESS_TOKEN = 'access_token';
  const PARAM_GRANT = 'grant_type';
  const PARAM_CLIENT_ID = 'client_id';
  const PARAM_CLIENT_SECRET = 'client_secret';
  
  const OPT_CREDENTIALS = 'client_credentials';
  
  const TOKEN_URL = 'https://thepulseapi.earthnetworks.com/oauth20/token';
  
  private $token;
  
  /**
   * 
   * @param string $clientId
   * @param string $clientSecret
   * @param \RainDrop\Storage\Base $storage
   * @throws \Exception
   */
  public function __construct($clientId, $clientSecret, $storage = null)
  {
    $token = null;
    
    if (!empty($storage))
    {
      $token = $storage->get(self::PARAM_ACCESS_TOKEN);
    }
    
    if (empty($token))
    {
      $token = $this->loadToken($clientId, $clientSecret, $expire);
      
      if (!empty($storage))
      {
        $storage->set(self::PARAM_ACCESS_TOKEN, $token, $expire - 3600);
      }
    }
    
    $this->token = $token;
  }
  
  /**
   * 
   * @param \RainDrop\Api\Request\Base $req
   */
  public function execute(Request\Base $req)
  {
    $url = $req->getUrl();
    $params = $req->getParams();
    $params[self::ACCESS_TOKEN] = $this->getToken();
    
    $resp = $this->doExecute($url, $params);
  }
  
  /**
   * 
   * @param string $url
   * @param string[] $params
   * @return string[]
   */
  protected function doExecute($url, $params)
  {
    $url .= ('?' . http_build_query($params, null, '&'));
    $ch = \curl_init($url);
    
    \curl_setopt_array($ch, array( 
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HEADER         => false,
      CURLOPT_CONNECTTIMEOUT => 60,
      CURLOPT_TIMEOUT        => 60,
    ));
    
    $resp = \curl_exec($ch);
    \curl_close($ch);
    return $resp;
  }
  

  /**
   * 
   * @param string $clientId
   * @param string $clientSecret
   * @param int &$expire
   * @throws \Exception
   */
  protected function loadToken($clientId, $clientSecret, &$expire = null)
  {
    $tokenJson = $this->doExecute(self::TOKEN_URL, array(
      self::PARAM_GRANT => self::OPT_CREDENTIALS,
      self::PARAM_CLIENT_ID => $clientId,
      self::PARAM_CLIENT_SECRET => $clientSecret,
    ));
    
    $tokenArray = \json_decode($tokenJson, true);
    
    if (empty($tokenArray) 
      || empty($tokenArray['OAuth20']['access_token']['token']))
    {
      // Must of had a problem
      throw new \Exception("Unable to parse token json response, '$tokenJson'");
    }
    
    $expire = (int)$tokenArray['OAuth20']['access_token']['expires_in'];
    return $tokenArray['OAuth20']['access_token']['token'];
  }

  /**
   * 
   * @return string
   */
  protected function getToken()
  {
    return $this->token;
  }
}
