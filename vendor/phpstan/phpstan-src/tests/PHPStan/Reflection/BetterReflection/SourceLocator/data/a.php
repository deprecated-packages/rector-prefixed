<?php

namespace _PhpScoper88fe6e0ad041\TestSingleFileSourceLocator;

class AFoo
{
}
function doFoo()
{
}
\define('_PhpScoper88fe6e0ad041\\TestSingleFileSourceLocator\\SOME_CONSTANT', 1);
const ANOTHER_CONSTANT = 2;
if (\false) {
    class InCondition
    {
    }
} elseif (\true) {
    class InCondition extends \_PhpScoper88fe6e0ad041\TestSingleFileSourceLocator\AFoo
    {
    }
} else {
    class InCondition extends \stdClass
    {
    }
}
