<?php

namespace _PhpScoper26e51eeacccf\PropertyAssignIntersectionStaticTypeBug;

abstract class Base
{
    /** @var string */
    private $foo;
    public function __construct(string $foo)
    {
        \assert($this instanceof \_PhpScoper26e51eeacccf\PropertyAssignIntersectionStaticTypeBug\Frontend || $this instanceof \_PhpScoper26e51eeacccf\PropertyAssignIntersectionStaticTypeBug\Backend);
        $this->foo = $foo;
    }
}
class Frontend extends \_PhpScoper26e51eeacccf\PropertyAssignIntersectionStaticTypeBug\Base
{
}
class Backend extends \_PhpScoper26e51eeacccf\PropertyAssignIntersectionStaticTypeBug\Base
{
}
