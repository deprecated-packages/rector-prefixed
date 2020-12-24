<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
interface TypedTag
{
    public function getType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
    /**
     * @param Type $type
     * @return static
     */
    public function withType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : self;
}
