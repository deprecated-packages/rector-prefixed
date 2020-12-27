<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\PhpDoc\Tag;

use PHPStan\Type\Type;
interface TypedTag
{
    public function getType() : \PHPStan\Type\Type;
    /**
     * @param Type $type
     * @return static
     */
    public function withType(\PHPStan\Type\Type $type) : self;
}
