<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\PhpDoc\Tag;

use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
interface TypedTag
{
    public function getType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
    /**
     * @param Type $type
     * @return static
     */
    public function withType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : self;
}
