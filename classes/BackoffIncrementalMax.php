<?php 
/**
 *
 * BackoffIncrementalMax
 *   Enforces a maximum limit on the time parameter for a BackoffIncremental class.
 */

namespace BackoffLib;

class BackoffIncrementalMax extends BackoffIncremental implements IBackoffMaximum {
  protected $max = 32;

  function __construct($inc = 1, $maximumTime = 32) {
    parent::__construct($inc);
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
    //if ($this->getTime() > $this->getMaximum())
    if (!$this->checkTime())
      $this->time = $this->getMaximum();
    return $this->time;
  }
  
}