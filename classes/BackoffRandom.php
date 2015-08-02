<?php 
/**
 * @author trick.developer@gmail.com
 * @package BackoffLib
 * @license MIT
 * @version 1.2
 * 
 * Implements a random backoff algorithm.
 */

namespace BackoffLib;

class BackoffRandom extends BackoffBase {
  protected $minValue = 1;
  protected $maxValue = 120;
    
  public function __construct($minValue, $maxValue) {
    $this->minValue = $minValue;
    $this->maxValue = $maxValue;
  }
  
  protected function getInterval() {
    $this->interval = mt_rand($this->minValue, $this->maxValue);
    return $this->interval;
  }
  
  public function setMinValue($value) {
    $this->minValue = $value;
  }
  
  public function setMaxnValue($value) {
    $this->maxValue = $value;
  }
  
  public function getMinValue() {
    return $this->minValue;
  }
  
  public function getMaxValue() {
    return $this->maxValue;
  }
  
}