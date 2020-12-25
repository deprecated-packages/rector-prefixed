<?php

declare (strict_types=1);
namespace Rector\Defluent\Tests\NodeFactory\FluentChainMethodCallRootExtractor\Source;

final class AnotherTypeFactory
{
    /**
     * @return SomeClassWithFluentMethods
     */
    public function createSomeClassWithFluentMethods()
    {
        return new \Rector\Defluent\Tests\NodeFactory\FluentChainMethodCallRootExtractor\Source\SomeClassWithFluentMethods();
    }
}
