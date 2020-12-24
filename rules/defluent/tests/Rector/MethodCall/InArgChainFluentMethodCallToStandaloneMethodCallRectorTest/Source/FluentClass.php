<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Defluent\Tests\Rector\MethodCall\InArgChainFluentMethodCallToStandaloneMethodCallRectorTest\Source;

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
