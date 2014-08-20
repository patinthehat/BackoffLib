<?php
/**
 * @author trick.developer@gmail.com
 * @package BackoffLib
 * @version 1.1
 * 
 * autoloader for the BackoffLib classes.
 * 
 */

define('BACKOFF_AUTOLOAD_DEBUG',  TRUE);

function shortened_filename($filename) {
  $home = getenv('HOME');
  $path = "$home/";
  $path = realpath(dirname(__FILE__)."/..")."/";
  $ret = trim($filename);
  $ret = str_replace($path, '', $ret);
  return $ret;
}

function backoff_autoload($class) {
  $className = $class;
  $className = str_replace("_", DIRECTORY_SEPARATOR, $className);
  $className = preg_replace("/^BackoffLib\\\\(.*)$/", "$1", $className);
  $fn = dirname(__FILE__).DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR."{$className}.php";
  if (file_exists($fn)) {
    if (BACKOFF_AUTOLOAD_DEBUG)
      echo "[DEBUG] autoload_class($className) \t: ".shortened_filename($fn)."".PHP_EOL;
    require_once($fn);
    return TRUE;
  }
  $fn = dirname(__FILE__).DIRECTORY_SEPARATOR."interfaces".DIRECTORY_SEPARATOR."{$className}.php";
  if (file_exists($fn)) {
    if (BACKOFF_AUTOLOAD_DEBUG)
      echo "[DEBUG] autoload_interface($className) \t: ".shortened_filename($fn)."".PHP_EOL;
    require_once($fn);
    return TRUE;
  }  
  return FALSE;
}

spl_autoload_register('backoff_autoload');

