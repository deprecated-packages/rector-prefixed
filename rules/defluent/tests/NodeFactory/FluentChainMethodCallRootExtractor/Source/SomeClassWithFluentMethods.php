<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Defluent\Tests\NodeFactory\FluentChainMethodCallRootExtractor\Source;

final class SomeClassWithFluentMethods
{
    /**
     * @return self
     */
    public function one()
    {
        return $this;
    }
    /**
     * @return $this
     */
    public function two()
    {
        return $this;
    }
}
