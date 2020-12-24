<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Defluent\Tests\Rector\Return_\ReturnNewFluentChainMethodCallToNonFluentRector\Source;

final class DifferentReturnValues implements \_PhpScopere8e811afab72\Rector\Defluent\Tests\Rector\Return_\ReturnNewFluentChainMethodCallToNonFluentRector\Source\FluentInterfaceClassInterface
{
    public function someFunction() : self
    {
        return $this;
    }
    public function otherFunction() : int
    {
        return 5;
    }
}
