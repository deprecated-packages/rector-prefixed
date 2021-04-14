<?php

declare(strict_types=1);

namespace Symplify\Astral\ValueObject\NodeBuilder;

use PhpParser\Builder\Use_;
use PhpParser\Node\Stmt\Use_ as UseStmt;

/**
 * Fixed duplicated naming in php-parser and prevents confusion
 */
final class UseBuilder extends Use_
{
    public function __construct($name, int $type = UseStmt::TYPE_NORMAL)
    {
        parent::__construct($name, $type);
    }
}
