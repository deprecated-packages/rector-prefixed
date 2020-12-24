<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Defluent\Tests\Rector\MethodCall\FluentChainMethodCallToNormalMethodCallRector\Source;

final class QueryBuilder
{
    public function addQuery() : self
    {
        return $this;
    }
    public function select() : self
    {
        return $this;
    }
}
