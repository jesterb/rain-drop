<?php

namespace RainDrop\Test\Unit\Config;
use RainDrop\Test;

require_once TEST_ROOT . '/mock/config/Handler.php';

class HandlerTest extends \PHPUnit_Framework_TestCase
{
  public function testGet()
  {
    $data = array(
      'section1' => array(
        'test' => 1001,
      ),
      'section2' => array(),
    );
    
    $handler = new Test\Mock\Config\Handler($data);
    
    $this->assertEquals($data['section1']['test'], 
      $handler->get('test', 'section1'));
  }
}
