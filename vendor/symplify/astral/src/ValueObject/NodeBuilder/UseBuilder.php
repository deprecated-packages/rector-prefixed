<?php

declare (strict_types=1);
namespace RectorPrefix20210503\Symplify\Astral\ValueObject\NodeBuilder;

use PhpParser\Builder\Use_;
use PhpParser\Node\Stmt\Use_ as UseStmt;
/**
 * Fixed duplicated naming in php-parser and prevents confusion
 */
final class UseBuilder extends \PhpParser\Builder\Use_
{
    public function __construct($name, int $type = \PhpParser\Node\Stmt\Use_::TYPE_NORMAL)
    {
        parent::__construct($name, $type);
    }
}
