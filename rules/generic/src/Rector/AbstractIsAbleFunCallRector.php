<?php

declare (strict_types=1);
namespace Rector\Generic\Rector;

use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;
use Rector\Core\Rector\AbstractRector;
use Rector\Generic\Contract\IsAbleFuncCallInterface;
use Rector\Php71\IsArrayAndDualCheckToAble;
abstract class AbstractIsAbleFunCallRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Generic\Contract\IsAbleFuncCallInterface
{
    /**
     * @var IsArrayAndDualCheckToAble
     */
    private $isArrayAndDualCheckToAble;
    public function __construct(\Rector\Php71\IsArrayAndDualCheckToAble $isArrayAndDualCheckToAble)
    {
        $this->isArrayAndDualCheckToAble = $isArrayAndDualCheckToAble;
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\BinaryOp\BooleanOr::class];
    }
    /**
     * @param BooleanOr $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
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
