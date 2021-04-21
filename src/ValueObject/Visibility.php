<?php

declare (strict_types=1);
namespace Rector\Core\ValueObject;

use PhpParser\Node\Stmt\Class_;
final class Visibility
{
    /**
     * @var int
     */
    const PUBLIC = \PhpParser\Node\Stmt\Class_::MODIFIER_PUBLIC;
    /**
     * @var int
     */
    const PROTECTED = \PhpParser\Node\Stmt\Class_::MODIFIER_PROTECTED;
    /**
     * @var int
     */
    const PRIVATE = \PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE;
    /**
     * @var int
     */
    const STATIC = \PhpParser\Node\Stmt\Class_::MODIFIER_STATIC;
    /**
     * @var int
     */
    const ABSTRACT = \PhpParser\Node\Stmt\Class_::MODIFIER_ABSTRACT;
    /**
     * @var int
     */
    const FINAL = \PhpParser\Node\Stmt\Class_::MODIFIER_FINAL;
}
