<?php

namespace BackoffLib;


class BackoffExponentialMaxTest extends \PHPUnit_Framework_TestCase
{
    public function testCount()
    {
      $be = new BackoffExponentialMax(2,4);
      $be->backoff();
      $be->backoff();
      $be->backoff();
      $be->backoff();
      $this->assertSame($be->getTime(), 4);
    }

}

?>