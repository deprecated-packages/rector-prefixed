<?php

declare (strict_types=1);
namespace Rector\Defluent\Tests\Rector\Return_\ReturnFluentChainMethodCallToNormalMethodCallRector\Source;

final class Row
{
    public function addCell() : \Rector\Defluent\Tests\Rector\Return_\ReturnFluentChainMethodCallToNormalMethodCallRector\Source\Cell
    {
        return new \Rector\Defluent\Tests\Rector\Return_\ReturnFluentChainMethodCallToNormalMethodCallRector\Source\Cell();
    }
}
