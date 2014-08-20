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
A set of classes that implements various backoff (delay) routines, such as 
[exponential backoff](http://en.wikipedia.org/wiki/Exponential_backoff).
The classes can be used for implementing various types of delays (_i.e. using [`sleep()`](http://php.net/manual/en/function.sleep.php), delays between http requests._)
To execute, call `$class->backoff();`
The `backoff()` function is declared abstract in `BackoffBase` and implemented in the
various child classes.

  + A _exponential backoff_ delay with a default exponent of 2 
    will increment in the following way: `1, 2, 4, 16, 256`

  + An _incremental backoff_ delay with a default increment of 1 
    will increment in the following way: `1, 2, 3, 4, 5, 6, 7`

  + A _multiplicative backoff_ delay with a default exponent of 2 
    will increment in the following way: `0.5, 1, 2, 4, 8, 16, 32, 64`

<br/>

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

---


### Examples

```php
require('BackoffLib/Backoff.php');
$be = new BackoffLib\BackoffIncrementalMax(1, 2); //increment by 1, max 2
function beo($b) {
  $b->backoff();
  echo "\$b->time = ".$b->getTime() . PHP_EOL;
}
beo($be);
beo($be);
beo($be);
echo "be->getCount = ".$be->getCount().PHP_EOL;
```

---

```php
require('BackoffLib/Backoff.php');

$be = new BackoffLib\BackoffExponential();
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


