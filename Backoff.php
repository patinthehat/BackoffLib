<?php
/**
 * autoloader for the BackoffLib classes.
 * 
 */

define('BACKOFF_AUTOLOAD_DEBUG',  !true);


function shortened_filename($filename) {
  $home = getenv('HOME');
  $path = "$home/Development/";
  $ret = trim($filename);
  $ret = str_replace($path, '', $ret);
  return $ret;
}

function center($text, $len, $padChar = " ") {
  if (strlen($text)<$len) {
    $nlen = $len - strlen($text); 
    $n = floor($nlen / 2);
    $pad = str_repeat($padChar, $n);
    $ret = $pad . $text . $pad;
    $ret = substr($ret,0,$len);
    return $ret;
  }
  return $text;
}

function require_class($name) {
  $name = trim($name);
  $name = str_replace('..','',$name);
  $fn = dirname(__FILE__)."/classes/${name}.php";
  if (strlen($name)<20)
    $name = center($name, 20);
  
  if (BACKOFF_AUTOLOAD_DEBUG)
    echo "[DEBUG] require_class($name) \t: ".shortened_filename($fn)."".PHP_EOL;
  require_once($fn);
}

function require_interface($name) {
  $name = trim($name);
  $name = str_replace('..','',$name);
  $fn = dirname(__FILE__)."/interfaces/${name}.php";
  if (BACKOFF_AUTOLOAD_DEBUG)
    echo "[DEBUG] require_interface($name) \t: ".shortened_filename($fn)."".PHP_EOL;
  require_once($fn);
}

function require_intf($name) { 
  require_interface($name); 
}

function autoload_backoff() {
  require_intf ('IBackoffMaximum');
  require_class('BackoffBase');
  require_class("BackoffIncremental");
  require_class("BackoffIncrementalMax");
  require_class('BackoffExponential');
  require_class('BackoffExponentialMax');
}

autoload_backoff();

echo center("autoload complete", 80, "-").PHP_EOL;