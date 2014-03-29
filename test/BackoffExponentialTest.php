<?php

namespace BackoffLib;


class BackoffExponentialTest extends \PHPUnit_Framework_TestCase
{
    public function testCount()
    {
      $be = new BackoffExponential();
      $be->backoff();
      $be->backoff();
      $this->assertSame($be->getCount(), 2);
    }

}

?>
