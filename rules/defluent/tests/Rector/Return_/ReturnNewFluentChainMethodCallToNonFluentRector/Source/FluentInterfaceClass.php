<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Defluent\Tests\Rector\Return_\ReturnNewFluentChainMethodCallToNonFluentRector\Source;

final class FluentInterfaceClass extends \_PhpScopere8e811afab72\Rector\Defluent\Tests\Rector\Return_\ReturnNewFluentChainMethodCallToNonFluentRector\Source\InterFluentInterfaceClass
{
    /**
     * @var int
     */
    private $value = 0;
    public function someFunction() : self
    {
        return $this;
    }
    public function otherFunction() : self
    {
        return $this;
    }
    public function voidReturningMethod()
    {
        $this->value = 100;
    }
}
