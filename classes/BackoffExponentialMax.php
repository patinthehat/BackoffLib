<?php 
/**
 * @author trick.developer@gmail.com
 * @package BackoffLib
 * @license MIT
 * @version 1.2
 * 
 * BackoffExponentialMax
 *   Enforces a maximum limit on the time parameter for a BackoffExponential class.
 */

namespace BackoffLib;


class BackoffExponentialMax extends BackoffExponential implements IBackoffMaximum {
  protected $max = 32;

  function __construct($exp = 2, $maximumTime = 32) {
    parent::__construct($exp);
    if (is_numeric($maximumTime))
      $this->setMaximum($maximumTime);
  }
  
  public function getMaximum() {
    return $this->max;
  }
  
  public function setMaximum($value) {
    $this->max = $value;
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