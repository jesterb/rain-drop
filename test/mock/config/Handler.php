<?php

namespace RainDrop\Test\Mock\Config;

class Handler extends \RainDrop\Config\Handler
{
  private $testData; 
  
  public function __construct($data)
  {
    $this->testData = $data;
    parent::__construct('fake_file.ini');
  }
  
  protected function read($file)
  {
    return $this->testData;
  }
}
