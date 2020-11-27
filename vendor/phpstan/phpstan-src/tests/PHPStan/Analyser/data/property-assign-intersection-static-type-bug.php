<?php

namespace _PhpScoper006a73f0e455\PropertyAssignIntersectionStaticTypeBug;

abstract class Base
{
    /** @var string */
    private $foo;
    public function __construct(string $foo)
    {
        \assert($this instanceof \_PhpScoper006a73f0e455\PropertyAssignIntersectionStaticTypeBug\Frontend || $this instanceof \_PhpScoper006a73f0e455\PropertyAssignIntersectionStaticTypeBug\Backend);
        $this->foo = $foo;
    }
}
class Frontend extends \_PhpScoper006a73f0e455\PropertyAssignIntersectionStaticTypeBug\Base
{
}
class Backend extends \_PhpScoper006a73f0e455\PropertyAssignIntersectionStaticTypeBug\Base
{
}
