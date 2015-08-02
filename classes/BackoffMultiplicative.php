<?php 
/**
 * @author trick.developer@gmail.com
 * @package BackoffLib
 * @license MIT
 * @version 1.2
 * 
 * Implements an linear multiplicative backoff algorithm (multiplicative delay)
 * 
 * For example, an exponent of 2 (the default) would result in the following:
 *    #    delay
 *    --   -----
 *    1    1        
 *    2    2        
 *    3    4        
 *    4    8        
 *    5    16       
 *    ...
 *    ============
 * 
 */

namespace BackoffLib;


class BackoffMultiplicative extends BackoffBase {
  protected $exponent = 2;

  public function __construct($exp = 2) {
    if (is_numeric($exp) && $exp > 0)
      $this->exponent = $exp;
  }

  protected function getInterval() {
    $this->interval = $this->interval * $this->exponent;
    
    if ($this->interval <= 0)
      $this->interval = 1;
    return $this->interval;
  }
  
  public function backoff() {
    parent::backoff();
  }
}