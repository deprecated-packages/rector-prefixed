<?php

namespace _PhpScoperbd5d0c5f7638\TestSingleFileSourceLocator;

class AFoo
{
}
function doFoo()
{
}
\define('_PhpScoperbd5d0c5f7638\\TestSingleFileSourceLocator\\SOME_CONSTANT', 1);
const ANOTHER_CONSTANT = 2;
if (\false) {
    class InCondition
    {
    }
} elseif (\true) {
    class InCondition extends \_PhpScoperbd5d0c5f7638\TestSingleFileSourceLocator\AFoo
    {
    }
} else {
    class InCondition extends \stdClass
    {
    }
}
