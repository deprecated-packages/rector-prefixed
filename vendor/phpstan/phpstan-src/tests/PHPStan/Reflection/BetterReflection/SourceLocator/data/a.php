<?php

namespace _PhpScoper006a73f0e455\TestSingleFileSourceLocator;

class AFoo
{
}
function doFoo()
{
}
\define('_PhpScoper006a73f0e455\\TestSingleFileSourceLocator\\SOME_CONSTANT', 1);
const ANOTHER_CONSTANT = 2;
if (\false) {
    class InCondition
    {
    }
} elseif (\true) {
    class InCondition extends \_PhpScoper006a73f0e455\TestSingleFileSourceLocator\AFoo
    {
    }
} else {
    class InCondition extends \stdClass
    {
    }
}
