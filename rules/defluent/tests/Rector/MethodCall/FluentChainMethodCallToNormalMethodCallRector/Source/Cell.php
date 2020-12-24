<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Defluent\Tests\Rector\MethodCall\FluentChainMethodCallToNormalMethodCallRector\Source;

final class Cell
{
    public function setName($name) : self
    {
        return $this;
    }
}
