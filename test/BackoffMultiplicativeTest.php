<?php

namespace BackoffLib;


class BackoffMultiplicativeTest extends \PHPUnit_Framework_TestCase
{

    public function testCount()
    {
      $be = new BackoffMultiplicative();
      $be->backoff();
      $be->backoff();
      $this->assertSame($be->getCount(), 2);
    }
    
    public function testMutliplication()
    {
      $be = new BackoffMultiplicative(2.0);
      $be->backoff();
      $be->backoff();
      $be->backoff();
      $one = $be->getIntervalValue();
      $be->backoff();
      $two = $be->getIntervalValue();
      
      $this->assertSame(round($two / 2.0), round($one));
    }
    
    public function testReset()
    {
      $be = new BackoffMultiplicative();
      $be->backoff();
      $be->reset();
      $this->assertSame($be->getCount(), 0);
      $this->assertSame($be->getIntervalValue(), 0);
    }

    public function testFailure()
    {
      $be = new BackoffMultiplicative();
      $be->backoff();
      $this->assertNotSame(2, $be->getCount());
    }


    public function testTime()
    {
      $be = new BackoffMultiplicative();
      $be->backoff();
      $be->backoff();
      $be->backoff();
      $this->assertSame(round($be->getIntervalValue()), 4.0);
    }

}

?>
