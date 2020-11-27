<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf;

use Rector\Core\Stubs\StubLoader;
require_once __DIR__ . '/../vendor/autoload.php';
// silent deprecations, since we test them
\error_reporting(\E_ALL ^ \E_DEPRECATED);
// performance boost
\gc_disable();
// load stubs
$stubLoader = new \Rector\Core\Stubs\StubLoader();
$stubLoader->loadStubs();
