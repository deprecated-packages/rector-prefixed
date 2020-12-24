<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder;

use _PhpScoperb75b35f52b74\PhpParser\Builder\Use_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_ as UseStmt;
/**
 * Fixed duplicated naming in php-parser and prevents confusion
 */
final class UseBuilder extends \_PhpScoperb75b35f52b74\PhpParser\Builder\Use_
{
    public function __construct($name, int $type = \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Use_::TYPE_NORMAL)
    {
        parent::__construct($name, $type);
    }
}
