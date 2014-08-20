<?php
/**
 * @author trick.developer@gmail.com
 * @package BackoffLib
 * @license MIT
 * @version 1.1
 *
 * Implements a delay handler callback and a OnFire callback function.  Can be used to  
 * quickly implement a backoff with minimal code.
 * 
 *    The callback can be used to limit the number of times it is triggered, or limit the 
 *    maximum delay.  It should return TRUE to continue running, or FALSE to halt execution.
 *        function bool callback($data);
 * 
 *    The delay callback should implement a delay that handles the delay time of $backoff.  This
 *    could be as simple as calling sleep().  Should return 0 on success, or -1 on an error.
 *        function bool delayCallback($length);
 * 
 */


namespace BackoffLib;


class BackoffCaller {
  protected $bo = null;
  protected $cb = null;
  protected $delayCb = null;

  /**
   * @codeCoverageIgnore
   */
  function __construct(BackoffBase $backoff,callable $callback, callable $delayCb) {
    $this->bo = $backoff;
    $this->cb = $callback;  
    $this->delayCb = $delayCb;
  }

  /**
   * @codeCoverageIgnore
   */
  function delay($len) {
    if ($ret = call_user_func($this->delayCb, $len)===0)  //on Windows, sleep() may not return 0 on success
      return true;
    return false;
  }

  /**
   * @codeCoverageIgnore
   */
  function run($initialValue = false) {
    $r = $initialValue;
    while($r != true) {
      $this->bo->backoff();
      
      if ($this->delay($this->bo->getTime())!==TRUE) 
        throw new \Exception(__CLASS__."->delay() failed.");

      $r = call_user_func($this->cb,  $this->bo->getTime());
      if ($r)
        break;
    }
    return true;
  }
}
