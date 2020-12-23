<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\PhpDoc\Tag;

use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
interface TypedTag
{
    public function getType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
    /**
     * @param Type $type
     * @return static
     */
    public function withType(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : self;
}
