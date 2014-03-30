<?php

namespace BackoffLib;


class BackoffCaller {
  protected $bo = null;
  protected $cb = null;

  /**
   * @codeCoverageIgnore
   */
  function __construct(BackoffBase $backoff,callable $callback) {
    $this->bo = $backoff;
    $this->cb = $callback;  
  }

  /**
   * @codeCoverageIgnore
   */
  function delay($len) {
    if (sleep($len)===0)  //this line should be commented out on windows
      return $len;
    return false;
  }

  /**
   * @codeCoverageIgnore
   */
  function run($initialValue = false) {
    $r = $initialValue;
    while($r != true) {
      $this->bo->backoff();
      //echo "[dbg] time = ".$this->bo->getTime().PHP_EOL;
      if (!$this->delay($this->bo->getTime())) 
        throw new \Exception("BackoffCaller->delay() failed.");

      $r = call_user_func($this->cb, $this->bo->getTime());
      if ($r)
        break;
    }
    return true;
  }
}
