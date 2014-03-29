<?php 
/*
 * Implements an exponential backoff algorithm (exponential delay)
 */

namespace BackoffLib;


class BackoffExponential extends BackoffBase {
  protected $exponent = 2;

  public function __construct($exp = 2) {
    if (is_int($exp) && $exp > 0)
      $this->exponent = $exp;
  }

  protected function getInterval() {
    $this->interval = ($this->interval * $this->exponent);
    if ($this->interval==0)
      $this->interval = 1;
    return $this->interval;
  }
  
  public function backoff() {
    parent::backoff();
  }
}