<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Rector;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanOr;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Generic\Contract\IsAbleFuncCallInterface;
use _PhpScopere8e811afab72\Rector\Php71\IsArrayAndDualCheckToAble;
abstract class AbstractIsAbleFunCallRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Generic\Contract\IsAbleFuncCallInterface
{
    /**
     * @var IsArrayAndDualCheckToAble
     */
    private $isArrayAndDualCheckToAble;
    public function __construct(\_PhpScopere8e811afab72\Rector\Php71\IsArrayAndDualCheckToAble $isArrayAndDualCheckToAble)
    {
        $this->isArrayAndDualCheckToAble = $isArrayAndDualCheckToAble;
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanOr::class];
    }
    /**
     * @param BooleanOr $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($this->shouldSkip()) {
            return null;
        }
        return $this->isArrayAndDualCheckToAble->processBooleanOr($node, $this->getType(), $this->getFuncName()) ?: $node;
    }
    private function shouldSkip() : bool
    {
        if (\function_exists($this->getFuncName())) {
            return \false;
        }
        return $this->isAtLeastPhpVersion($this->getPhpVersion());
    }
}
