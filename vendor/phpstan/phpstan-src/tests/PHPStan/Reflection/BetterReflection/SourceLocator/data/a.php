<?php

namespace _PhpScopera143bcca66cb\TestSingleFileSourceLocator;

class AFoo
{
}
function doFoo()
{
}
\define('_PhpScopera143bcca66cb\\TestSingleFileSourceLocator\\SOME_CONSTANT', 1);
const ANOTHER_CONSTANT = 2;
if (\false) {
    class InCondition
    {
    }
} elseif (\true) {
    class InCondition extends \_PhpScopera143bcca66cb\TestSingleFileSourceLocator\AFoo
    {
    }
} else {
    class InCondition extends \stdClass
    {
    }
}
