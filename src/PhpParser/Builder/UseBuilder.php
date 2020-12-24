<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder;

use _PhpScoper0a6b37af0871\PhpParser\Builder\Use_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Use_ as UseStmt;
/**
 * Fixed duplicated naming in php-parser and prevents confusion
 */
final class UseBuilder extends \_PhpScoper0a6b37af0871\PhpParser\Builder\Use_
{
    public function __construct($name, int $type = \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Use_::TYPE_NORMAL)
    {
        parent::__construct($name, $type);
    }
}
