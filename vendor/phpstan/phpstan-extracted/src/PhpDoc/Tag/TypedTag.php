<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\PhpDoc\Tag;

use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
interface TypedTag
{
    public function getType() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type;
    /**
     * @param Type $type
     * @return static
     */
    public function withType(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : self;
}
