### BackoffLib

[Build Status](https://travis-ci.org/patinthehat/BackoffLib.png)](https://travis-ci.org/patinthehat/BackoffLib/)
[Build Status][(https://api.travis-ci.org/patinthehat/BackoffLib.png)]https://travis-ci.org/patinthehat/BackoffLib/)

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

A set of classes that implements various backoff (delay) routines, such as 
[exponential backoff](http://en.wikipedia.org/wiki/Exponential_backoff).
The classes can be used for implementing various types of delays (_i.e. using [`sleep()`](http://us2.php.net/manual/en/function.sleep.php), delays between http requests._)
To execute, call `$class->backoff();`
The `backoff()` function is declared abstract in `BackoffBase` and implemented in the
various child classes.

- An _exponential backoff_ delay with an exponent of 2 
  will increment in the following way: `1, 2, 4, 8, 16, 32, 64`

- An _incremental backoff_ delay with an increment of 1 
  will increment in the following way: `1, 2, 3, 4, 5, 6, 7`

<spacer />

---

### Classes


  + `BackoffBase` - base class that all BackoffLib classes are inherited from.
  + `BackoffExponential` - exponential backoff
  + `BackoffExponentialMax`- exponential backoff with maxiumum value
  + `BackoffIncremental` - incremental backoff
  + `BackoffIncrementalMax` - incremental backoff with maxiumum value

---


### Functions

  - `$Backoff->backoff();` : executes the backoff implementation.
  - `$Backoff->getInterval();` : implementation of the algorithm for the given class.  Modifies `$Backoff->interval`.
  - `$Backoff->getTime();` : returns the value of the backoff (delay) `$time` after calling `backoff()`.
  - `$Backoff->getIntervalValue();` : returns the value of the `$interval` for the class.

---


### Interfaces

  + `IBackoffMaximum` - implemented by classes having a maximum value.


---



### Examples
<div class="codeExample"><pre>`require('BackoffLib/Backoff.php');
$be = new BackoffLib\BackoffIncrementalMax(1, 2); //increment by 1, max 2
function beo($b) {
  $b->backoff();
  echo "\$b->time = ".$b->getTime() . PHP_EOL;
}
beo($be);
beo($be);
beo($be);
echo "be->getCount = ".$be->getCount().PHP_EOL;
`</pre></div>

<spacer />

<div class="codeExample"><pre>
`require('BackoffLib/Backoff.php');

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
`</pre></div>
