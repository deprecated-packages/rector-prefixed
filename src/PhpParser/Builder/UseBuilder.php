<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder;

use _PhpScoper0a2ac50786fa\PhpParser\Builder\Use_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Use_ as UseStmt;
/**
 * Fixed duplicated naming in php-parser and prevents confusion
 */
final class UseBuilder extends \_PhpScoper0a2ac50786fa\PhpParser\Builder\Use_
{
    public function __construct($name, int $type = \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Use_::TYPE_NORMAL)
    {
        parent::__construct($name, $type);
    }
}
