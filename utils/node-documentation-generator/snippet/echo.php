<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455;

use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Echo_;
$string = new \PhpParser\Node\Scalar\String_('hello');
return new \PhpParser\Node\Stmt\Echo_([$string]);
