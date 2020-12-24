<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Defluent\Tests\Rector\MethodCall\InArgChainFluentMethodCallToStandaloneMethodCallRectorTest\Source;

final class FluentClass
{
    public function someFunction() : self
    {
        return $this;
    }
    public function otherFunction() : self
    {
        return $this;
    }
}
