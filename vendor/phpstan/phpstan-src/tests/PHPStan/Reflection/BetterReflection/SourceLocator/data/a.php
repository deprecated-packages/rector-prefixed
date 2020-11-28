<?php

namespace _PhpScoperabd03f0baf05\TestSingleFileSourceLocator;

class AFoo
{
}
function doFoo()
{
}
\define('_PhpScoperabd03f0baf05\\TestSingleFileSourceLocator\\SOME_CONSTANT', 1);
const ANOTHER_CONSTANT = 2;
if (\false) {
    class InCondition
    {
    }
} elseif (\true) {
    class InCondition extends \_PhpScoperabd03f0baf05\TestSingleFileSourceLocator\AFoo
    {
    }
} else {
    class InCondition extends \stdClass
    {
    }
}
