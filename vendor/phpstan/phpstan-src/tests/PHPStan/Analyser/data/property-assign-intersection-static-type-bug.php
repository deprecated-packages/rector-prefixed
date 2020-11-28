<?php

namespace _PhpScoperabd03f0baf05\PropertyAssignIntersectionStaticTypeBug;

abstract class Base
{
    /** @var string */
    private $foo;
    public function __construct(string $foo)
    {
        \assert($this instanceof \_PhpScoperabd03f0baf05\PropertyAssignIntersectionStaticTypeBug\Frontend || $this instanceof \_PhpScoperabd03f0baf05\PropertyAssignIntersectionStaticTypeBug\Backend);
        $this->foo = $foo;
    }
}
class Frontend extends \_PhpScoperabd03f0baf05\PropertyAssignIntersectionStaticTypeBug\Base
{
}
class Backend extends \_PhpScoperabd03f0baf05\PropertyAssignIntersectionStaticTypeBug\Base
{
}
