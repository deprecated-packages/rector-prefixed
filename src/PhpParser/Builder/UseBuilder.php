<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Builder;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Builder\Use_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Use_ as UseStmt;
/**
 * Fixed duplicated naming in php-parser and prevents confusion
 */
final class UseBuilder extends \_PhpScoper2a4e7ab1ecbc\PhpParser\Builder\Use_
{
    public function __construct($name, int $type = \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Use_::TYPE_NORMAL)
    {
        parent::__construct($name, $type);
    }
}
