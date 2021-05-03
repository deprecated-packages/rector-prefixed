<?php

declare (strict_types=1);
namespace RectorPrefix20210503;

require __DIR__ . '/../src/tracy.php';
use RectorPrefix20210503\Tracy\Debugger;
// For security reasons, Tracy is visible only on localhost.
// You may force Tracy to run in development mode by passing the Debugger::DEVELOPMENT instead of Debugger::DETECT.
\RectorPrefix20210503\Tracy\Debugger::enable(\RectorPrefix20210503\Tracy\Debugger::DETECT, __DIR__ . '/log');
?>
<!DOCTYPE html><link rel="stylesheet" href="assets/style.css">

<h1>Tracy: fatal error demo</h1>

<?php 
if (\RectorPrefix20210503\Tracy\Debugger::$productionMode) {
    echo '<p><b>For security reasons, Tracy is visible only on localhost. Look into the source code to see how to enable Tracy.</b></p>';
}
require __DIR__ . '/assets/E_COMPILE_ERROR.php';
