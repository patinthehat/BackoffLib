<?php

namespace BackoffLib;


class BackoffExponentialTest extends \PHPUnit_Framework_TestCase
{
    protected $be = null;
    
    public function __construct() {
      $this->be = new BackoffExponential(2.0);
    }
    
    public function __destruct() {
      $this->be = null;
    }
    
    public function testCount()
    {
      $this->be->reset();
      for($i=1;$i<=3;$i++)
        $this->be->backoff();
      $this->assertSame($this->be->getCount(), 3);
    }

    public function testValidExponent() {
      $this->be->reset();
      $this->be->backoff();
      $one = $this->be->getIntervalValue();
      $this->be->backoff();
      $two = $this->be->getIntervalValue();      
      $this->assertSame((round($one)), round(sqrt($two)));
      
      $this->be->backoff();
      $one = $this->be->getIntervalValue();
      $this->be->backoff();
      $two = $this->be->getIntervalValue();
      $this->assertSame(round($one), round(sqrt($two)));
    }
}

?>
