<?php 
/**
 * 
 * BackoffExponentialMax
 *   Enforces a maximum limit on the time parameter for a BackoffExponential class.
 */

namespace BackoffLib;


class BackoffExponentialMax extends BackoffExponential implements IBackoffMaximum {
  protected $max = 32;

  function __construct($exp = 2, $maximumTime = 32) {
    parent::__construct($exp);
    if (is_int($maximumTime))
      $this->max = $maximumTime;
  }
  
  public function setMaximum(int $value) {
    $this->max = $value;
  }
  
  public function getMaximum() {
    return $this->max;
  }
  
  public function checkTime() {
    if ($this->getTime() > $this->getMaximum())
      return FALSE;
    return TRUE;
  }
  
  
  public function backoff() {
    parent::backoff();
    if (!$this->checkTime())
      $this->setTime($this->getMaximum());
    return $this->time;
  }

}