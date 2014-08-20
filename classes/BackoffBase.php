<?php 
/**
 * @author trick.developer@gmail.com
 * @package BackoffLib
 * @license MIT
 * @version 1.1
 * 
 * Base class for implementing a backoff algorithm (i.e. exponential).
 * Implementing the getInterval() function should set $interval to a new value.
 * 
 */

namespace BackoffLib;


abstract class BackoffBase {
  protected $count    = 0;
  protected $time     = 0;
  protected $interval = 0;

  abstract protected function getInterval();
  
  public function backoff() {
    $this->count++;
    $interval = $this->getInterval();
    $this->time = $interval;
    return $this->time;
  }
  
  public function getIntervalValue() {
    return $this->interval;
  }

  public function getTime() {
    return $this->time;
  }
  
  public function setTime($value) {
    $this->time = $value;
  }
  
  public function getCount() {
    return $this->count;
  }

  public function reset() {
    $this->count = 0;
    $this->time = 0;
    $this->interval = 0;
  }
  
  public function __toString() {
    return "". $this->getTime();
  }
}

