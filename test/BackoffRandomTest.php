<?php


class BackoffRandomTest extends \PHPUnit_Framework_TestCase
{
    
  public function testBackoff()
  {
    $bo = new \BackoffLib\BackoffRandom(1, 60);
    $bo->backoff();
    $this->assertTrue($bo->getTime() >= 1);
    $this->assertTrue($bo->getTime() <= 60);
  }  
  
  public function testConstructorAndValueGetters()
  {
    $bo = new \BackoffLib\BackoffRandom(1, 60);
    $this->assertEquals($bo->getMinValue(), 1);
    $this->assertEquals($bo->getMaxValue(), 60);
  }
  
  public function testValueGettersAndSetters()
  {
    $bo = new \BackoffLib\BackoffRandom(1, 60);
    $bo->setMaxnValue(31);
    $bo->setMinValue(29);
    
    $this->assertEquals($bo->getMaxValue(), 31);
    $this->assertEquals($bo->getMinValue(), 29);    
  }
  
}
