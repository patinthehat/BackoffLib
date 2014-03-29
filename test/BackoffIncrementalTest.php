<?php

namespace BackoffLib;


class BackoffIncrementalTest extends \PHPUnit_Framework_TestCase
{

    public function testCount()
    {
      $be = new BackoffIncremental();
      $be->backoff();
      $be->backoff();
      $this->assertSame($be->getCount(), 2);
    }
    public function testStr()
    {
      $be = new BackoffIncremental();
      $s = "$be";
      $this->assertSame($s, "0");
    }
    public function testReset()
    {
      $be = new BackoffIncremental();
      $be->backoff();
      $be->reset();
      $this->assertSame($be->getCount(), 0);
      $this->assertSame($be->getIntervalValue(), 0);
    }

    public function testFailure() {
      $be = new BackoffIncremental();
      $be->backoff();
      $this->assertNotSame(999, $be->getIncrement());
    }


    public function testTime()
    {
      $be = new BackoffIncremental();
      $be->backoff();
      $this->assertSame($be->getTime(), 1);
    }

}

?>
