<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Defluent\Tests\Rector\MethodCall\NewFluentChainMethodCallToNonFluentRector\Source;

final class FluentInterfaceClass extends \_PhpScoperb75b35f52b74\Rector\Defluent\Tests\Rector\MethodCall\NewFluentChainMethodCallToNonFluentRector\Source\InterFluentInterfaceClass
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
