<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PhpParser\Builder;

use _PhpScopere8e811afab72\PhpParser\Builder\Use_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_ as UseStmt;
/**
 * Fixed duplicated naming in php-parser and prevents confusion
 */
final class UseBuilder extends \_PhpScopere8e811afab72\PhpParser\Builder\Use_
{
    public function __construct($name, int $type = \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_::TYPE_NORMAL)
    {
        parent::__construct($name, $type);
    }
}
