<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Defluent\Tests\Rector\Return_\ReturnFluentChainMethodCallToNormalMethodCallRector\Source;

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
