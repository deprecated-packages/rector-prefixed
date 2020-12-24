<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Dependency;

interface ExportedNode
{
    public function equals(self $node) : bool;
    /**
     * @param mixed[] $properties
     * @return self
     */
    public static function __set_state(array $properties) : self;
    /**
     * @param mixed[] $data
     * @return self
     */
    public static function decode(array $data) : self;
}
