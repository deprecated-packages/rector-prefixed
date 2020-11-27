<?php

namespace _PhpScopera143bcca66cb\PropertyAssignIntersectionStaticTypeBug;

abstract class Base
{
    /** @var string */
    private $foo;
    public function __construct(string $foo)
    {
        \assert($this instanceof \_PhpScopera143bcca66cb\PropertyAssignIntersectionStaticTypeBug\Frontend || $this instanceof \_PhpScopera143bcca66cb\PropertyAssignIntersectionStaticTypeBug\Backend);
        $this->foo = $foo;
    }
}
class Frontend extends \_PhpScopera143bcca66cb\PropertyAssignIntersectionStaticTypeBug\Base
{
}
class Backend extends \_PhpScopera143bcca66cb\PropertyAssignIntersectionStaticTypeBug\Base
{
}
