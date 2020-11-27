<?php

namespace _PhpScoper88fe6e0ad041\PropertyAssignIntersectionStaticTypeBug;

abstract class Base
{
    /** @var string */
    private $foo;
    public function __construct(string $foo)
    {
        \assert($this instanceof \_PhpScoper88fe6e0ad041\PropertyAssignIntersectionStaticTypeBug\Frontend || $this instanceof \_PhpScoper88fe6e0ad041\PropertyAssignIntersectionStaticTypeBug\Backend);
        $this->foo = $foo;
    }
}
class Frontend extends \_PhpScoper88fe6e0ad041\PropertyAssignIntersectionStaticTypeBug\Base
{
}
class Backend extends \_PhpScoper88fe6e0ad041\PropertyAssignIntersectionStaticTypeBug\Base
{
}
