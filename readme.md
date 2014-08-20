### BackoffLib [![Build Status](https://travis-ci.org/patinthehat/BackoffLib.png)](https://travis-ci.org/patinthehat/BackoffLib)

---

<!--
<style>
h3 { color: white; background-color: #1F166F; /*6CA0EB; */ padding: 3px; }
code { background-color: #EEEFCF; white-space: pre; }
a { color: red; }
a:visited { color: red; }
.codeExample {
  margin-left:20px; 
  border: 1px dashed #5A5959; 
  padding: 5px;
  background-color: #C4DAF3;
  font-family: monospace;
  font-size: 9pt;
  font-style:italic;
  white-space: pre;
}
spacer, .spacer{ margin-bottom: 15px; height: 1px; width: 1px; display:block; }
</style>
-->
A PHP library that implements various backoff (delay) routines, such as [exponential backoff](http://en.wikipedia.org/wiki/Exponential_backoff).
The classes can be used for implementing various types of delays (_i.e. using [`sleep()`](http://php.net/manual/en/function.sleep.php), delays between http requests_). See below for a more descriptive usage example.
To execute, call `$class->backoff();`
The `backoff()` function is declared abstract in `BackoffBase` and implemented in the
various child classes.

  + A _exponential backoff_ delay with a default exponent of 2 
    will increment in the following way: `1, 2, 4, 16, 256`

  + An _incremental backoff_ delay with a default increment of 1 
    will increment in the following way: `1, 2, 3, 4, 5, 6, 7`

  + A _multiplicative backoff_ delay with a default exponent of 2 
    will increment in the following way: `0.5, 1, 2, 4, 8, 16, 32, 64`



  _Example Usage:  Using a backoff algorithm that slowly backs off api calls if they return a "busy" status code so the server isn't overwhelmed by repeated requests.  Each time the server returns a "busy" status, the delay between api calls increases._



---

### Classes


  + `BackoffBase` - base class that all BackoffLib classes are inherited from.
  + `BackoffCaller` - with a specified `BackoffBase` object: implements a delay handler callback and a OnFire callback function.  Can be used to quickly implement a backoff with minimal code.
  + `BackoffExponential` - exponential backoff
  + `BackoffExponentialMax`- exponential backoff with maxiumum value
  + `BackoffIncremental` - incremental backoff
  + `BackoffIncrementalMax` - incremental backoff with maxiumum value
  + `BackoffMultiplicative` - multiplicative backoff
  
  
---


### Functions

  + `$Backoff->backoff();` - executes the backoff implementation.
  + `$Backoff->getInterval();` - implementation of the algorithm for the given class.  Modifies `$Backoff->interval`.
  + `$Backoff->getTime();` - returns the value of the backoff (delay) `$time` after calling `backoff()`.
  + `$Backoff->getIntervalValue();` - returns the value of the `$interval` for the class.

   ` `

  + `$BackoffCaller($bo,$cb,$delayCb);` - creates a `BackoffCaller` object with the specified `BackoffBase` object, a `bool function($data);` callback, and a `int function($length)` delay callback _(return 0 on success)_.).  See file header for more descriptive usage.
  + `$BackoffCaller->run();` - executes the callback in a loop until it returns `true`.

---


### Interfaces

  + `IBackoffMaximum` - implemented by classes having a maximum value.


---


### Unit Tests

  + Unit tests are in _'test/'_, and should be written and pass before any pull requests.
  + [PHPUnit](http://www.phpunit.de) is required to run the unit tests.  Execute `phpunit` in the `BackoffLib` directory.
  
---


### Examples

```php
require('BackoffLib/Backoff.php');
$be = new BackoffLib\BackoffIncrementalMax(1, 2); //increment by 1, max 2
function beo($b) {
  $b->backoff();
  echo "\$b->time = ".$b->getTime() . PHP_EOL;
}
for($i = 1; $i <= 5; $i++)
  beo($be);
echo "be->getCount = ".$be->getCount() . PHP_EOL;
```

---

```php
require('BackoffLib/Backoff.php');

$be = new BackoffLib\BackoffExponential(2.0);
function beo($b, $backoff=true) {
  if ($backoff)
    $b->backoff();
  echo "\$b->time = ".$b->getTime() . PHP_EOL;
}
beo($be,false);
beo($be);
beo($be);
beo($be);
beo($be);
```

---

#### Using `BackoffCaller`

```php

  require_once('BackoffLib/Backoff.php');


  define('CB_MAX_COUNTER',      10);    //hard limit for number of times the callback fires
  define('CB_MAX_DELAY',        64);    //good limit for multiplicative backoff 

  //callback that fires on each backoff call
  $backoff_callback = function($delayValue) {
    static $counter = 0;
    $counter++; 

    if (is_numeric($delayValue))
      $delayValue = sprintf("%.2f", $delayValue); //truncate the value
      
    //output the call counter and the delay value 
    echo "[debug] callback #${counter}\t${delayValue} \n";

    if (isset($delayValue) && is_numeric($delayValue)) 
      if ($delayValue >= CB_MAX_DELAY) 
        return true;  //halt backoffCaller execution, the delay has reached its maximum allowed value
    if ($counter >= CB_MAX_COUNTER) 
      return true;    //halt execution, the callback counter has reached its maximum allowed value.
      
    return false;     //continue backoffCaller execution: the next delay->backoff calls will occur
  };

  $backoff_delay_callback = function($len) {
    sleep($len);  //implement a delay using sleep(): anything could be done here, i.e. limit the max delay.
    return 0;     //return 0 on success: the next backoff call will occur
  };
  
  //create a backoff that multiplies the interval by 2 each time it backs off
  $backoffClass = new BackoffLib\BackoffMultiplicative(2.0);  
  //create a caller class, that implements a basic delay-on-fire.  the delay is actually handled in the callback.
  $backoff = new BackoffLib\BackoffCaller($backoffClass, $backoff_callback, $backoff_delay_callback);

  $backoff->run();  //begin execution: can only be halted by returning TRUE from the callback.
```

---

### License 

`BackoffLib` is open source software, available under the MIT license.  See the LICENSE file for more information.

