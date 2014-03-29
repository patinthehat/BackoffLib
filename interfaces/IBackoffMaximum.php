<?php


namespace BackoffLib;


interface IBackoffMaximum {
  public function setMaximum($value);
  public function getMaximum();
  public function checkTime();
}