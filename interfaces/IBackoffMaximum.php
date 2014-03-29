<?php


namespace BackoffLib;


interface IBackoffMaximum {
  public function setMaximum(int $value);
  public function getMaximum();
  public function checkTime();
}