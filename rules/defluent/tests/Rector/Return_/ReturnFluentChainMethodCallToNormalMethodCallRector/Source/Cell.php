<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Defluent\Tests\Rector\Return_\ReturnFluentChainMethodCallToNormalMethodCallRector\Source;

final class Cell
{
    public function setName($name) : self
    {
        return $this;
    }
}
