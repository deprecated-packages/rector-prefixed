<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\PhpDoc\Tag;

use _PhpScopere8e811afab72\PHPStan\Type\Type;
interface TypedTag
{
    public function getType() : \_PhpScopere8e811afab72\PHPStan\Type\Type;
    /**
     * @param Type $type
     * @return static
     */
    public function withType(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : self;
}
