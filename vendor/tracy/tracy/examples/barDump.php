<?php

declare (strict_types=1);
namespace RectorPrefix20210504;

require __DIR__ . '/../src/tracy.php';
use RectorPrefix20210504\Tracy\Debugger;
// For security reasons, Tracy is visible only on localhost.
// You may force Tracy to run in development mode by passing the Debugger::DEVELOPMENT instead of Debugger::DETECT.
\RectorPrefix20210504\Tracy\Debugger::enable(\RectorPrefix20210504\Tracy\Debugger::DETECT, __DIR__ . '/log');
?>
<!DOCTYPE html><html class=arrow><link rel="stylesheet" href="assets/style.css">

<h1>Tracy: bar dump demo</h1>

<p>You can dump variables to bar in rightmost bottom egde.</p>

<?php 
$arr = [10, 20.2, \true, null, 'hello', (object) null, []];
\RectorPrefix20210504\bdump(\get_defined_vars());
\RectorPrefix20210504\bdump($arr, 'The Array');
\RectorPrefix20210504\bdump('<a href="#">test</a>', 'String');
if (\RectorPrefix20210504\Tracy\Debugger::$productionMode) {
    echo '<p><b>For security reasons, Tracy is visible only on localhost. Look into the source code to see how to enable Tracy.</b></p>';
}
