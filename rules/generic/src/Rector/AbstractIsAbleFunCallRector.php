<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Rector;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\BooleanOr;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Generic\Contract\IsAbleFuncCallInterface;
use _PhpScoper0a6b37af0871\Rector\Php71\IsArrayAndDualCheckToAble;
abstract class AbstractIsAbleFunCallRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a6b37af0871\Rector\Generic\Contract\IsAbleFuncCallInterface
{
    /**
     * @var IsArrayAndDualCheckToAble
     */
    private $isArrayAndDualCheckToAble;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Php71\IsArrayAndDualCheckToAble $isArrayAndDualCheckToAble)
    {
        $this->isArrayAndDualCheckToAble = $isArrayAndDualCheckToAble;
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\BooleanOr::class];
    }
    /**
     * @param BooleanOr $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
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
