<?php

declare (strict_types=1);
namespace Rector\Defluent\Tests\Rector\MethodCall\FluentChainMethodCallToNormalMethodCallRector\Source;

final class Row
{
    public function addCell() : \Rector\Defluent\Tests\Rector\MethodCall\FluentChainMethodCallToNormalMethodCallRector\Source\Cell
    {
        return new \Rector\Defluent\Tests\Rector\MethodCall\FluentChainMethodCallToNormalMethodCallRector\Source\Cell();
    }
}
