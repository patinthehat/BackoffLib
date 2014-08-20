<?php
/**
 * @author trick.developer@gmail.com
 * @package BackoffLib
 * @license MIT
 * @version 1.1
 *
 */

namespace BackoffLib;


interface IBackoffMaximum {
  public function setMaximum($value);
  public function getMaximum();
  public function checkTime();
}