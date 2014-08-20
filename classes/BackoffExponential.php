<?php 
/**
 * @author trick.developer@gmail.com
 * @package BackoffLib
 * @license MIT
 * @version 1.1
 * 
 * Implements an exponential backoff algorithm (exponential delay)
 * 
 * For example, an exponent of 2 (the default) would result in the following:
 *    #    delay
 *    --   -----
 *    1    1        
 *    2    2        
 *    3    4        
 *    4    16        
 *    5    256       
 *    ...
 *    ============
 * 
 */

namespace BackoffLib;


class BackoffExponential extends BackoffBase {
  protected $exponent = 2;

  public function __construct($exp = 2) {
    if (is_numeric($exp) && $exp > 0)
      $this->exponent = $exp;
  }

  protected function getInterval() {
    if ($this->interval <= 1) {
      $this->interval = pow($this->exponent, $this->interval);// (($this->interval*2) * $this->exponent);
    } else {
      $this->interval = pow($this->interval, $this->exponent);// * ($this->interval<$this->exponent?2.0:1.0);
    }
    
    if ($this->interval<0)
      $this->interval = 1;
    
        
    $this->interval = ($this->interval);
    return $this->interval;
  }
  
  public function backoff() {
    parent::backoff();
  }
}