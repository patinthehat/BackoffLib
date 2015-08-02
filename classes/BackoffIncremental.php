<?php 
/**
 * @author trick.developer@gmail.com
 * @package BackoffLib
 * @license MIT
 * @version 1.2
 * 
 * Implements an incremental backoff algorithm (incremental delay).
 */

namespace BackoffLib;

class BackoffIncremental extends BackoffBase {
  protected $increment = 1;
  
  public function __construct($inc = 1) {
    $this->setIncrement($inc);
  }
  
  protected function getInterval() {
    $this->interval = $this->interval + $this->increment;
    return $this->interval;
  }
  
  public function setIncrement($value) {
    $this->increment = $value;
  }
  
  public function getIncrement() {
    return $this->increment;
  }
}