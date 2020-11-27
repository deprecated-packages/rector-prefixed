<?php

namespace _PhpScoperbd5d0c5f7638\PropertyAssignIntersectionStaticTypeBug;

abstract class Base
{
    /** @var string */
    private $foo;
    public function __construct(string $foo)
    {
        \assert($this instanceof \_PhpScoperbd5d0c5f7638\PropertyAssignIntersectionStaticTypeBug\Frontend || $this instanceof \_PhpScoperbd5d0c5f7638\PropertyAssignIntersectionStaticTypeBug\Backend);
        $this->foo = $foo;
    }
}
class Frontend extends \_PhpScoperbd5d0c5f7638\PropertyAssignIntersectionStaticTypeBug\Base
{
}
class Backend extends \_PhpScoperbd5d0c5f7638\PropertyAssignIntersectionStaticTypeBug\Base
{
}
