<?php

namespace _PhpScoper88fe6e0ad041\WhileLoopLookForAssignsInBranchesVariableExistence;

class Foo
{
    public function doFoo()
    {
        $lastOffset = 1;
        while (\false !== ($index = \strpos('abc', \DIRECTORY_SEPARATOR, $lastOffset))) {
            $lastOffset = $index + 1;
        }
    }
}
