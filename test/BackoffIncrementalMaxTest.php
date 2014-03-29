<?php

namespace BackoffLib;


class BackoffIncrementalMaxTest extends \PHPUnit_Framework_TestCase
{
    public function testCount()
    {
      $be = new BackoffIncrementalMax(1,1);
      $be->backoff();
      $be->backoff();
      $be->backoff();
      $be->backoff();
      $this->assertSame($be->getTime(), 1);
    }

}

?>