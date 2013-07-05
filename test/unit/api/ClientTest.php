<?php

namespace RainDrop\Test\Unit\Api;
use RainDrop\Test\Mock;
use RainDrop\Api;

require_once TEST_ROOT . '/mock/api/Client.php';

class ClientTest extends \PHPUnit_Framework_TestCase
{
  public function testLoadToken()
  {
    $token = '123abc';
    $tokenResp = <<<JSON
{"OAuth20":{"access_token":{"token":"$token","refresh_token":"notused","token_type":"bearer","expires_in":86399}}}
JSON;
    
    $client = new Mock\Api\Client($tokenResp, null);
    
    $params = $client->getParams();
    
    $this->assertEquals(Api\Client::TOKEN_URL, $client->getUrl());
    $this->assertEquals(Mock\Api\Client::CLIENT_ID, 
      $params[Api\Client::PARAM_CLIENT_ID]);
    $this->assertEquals(Mock\Api\Client::CLIENT_SECRET, 
      $params[Api\Client::PARAM_CLIENT_SECRET]);
    $this->assertEquals(Api\Client::OPT_CREDENTIALS, 
      $params[Api\Client::PARAM_GRANT]);
    $this->assertEquals($token, $client->getToken());
  }
  
  public function testLoadTokenFail()
  {
    $token = '123abc';
    $tokenResp = <<<JSON
{"OAuth20":{"access_token":null}}
JSON;
    
    try
    {
      $client = new Mock\Api\Client($tokenResp, null);
      $this->assertTrue(false);
    }
    catch (\Exception $ex)
    {
      $this->assertTrue(true);
    }
  }
}
