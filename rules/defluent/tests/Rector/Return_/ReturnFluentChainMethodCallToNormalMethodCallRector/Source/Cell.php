<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Defluent\Tests\Rector\Return_\ReturnFluentChainMethodCallToNormalMethodCallRector\Source;

final class Cell
{
    public function setName($name) : self
    {
        return $this;
    }
}
