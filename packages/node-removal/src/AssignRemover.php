<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeRemoval;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\Rector\ChangesReporting\Collector\RectorChangeCollector;
use _PhpScoper0a6b37af0871\Rector\DeadCode\NodeManipulator\LivingCodeManipulator;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\PostRector\Collector\NodesToReplaceCollector;
final class AssignRemover
{
    /**
     * @var NodesToReplaceCollector
     */
    private $nodesToReplaceCollector;
    /**
     * @var RectorChangeCollector
     */
    private $rectorChangeCollector;
    /**
     * @var NodeRemover
     */
    private $nodeRemover;
    /**
     * @var LivingCodeManipulator
     */
    private $livingCodeManipulator;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\PostRector\Collector\NodesToReplaceCollector $nodesToReplaceCollector, \_PhpScoper0a6b37af0871\Rector\ChangesReporting\Collector\RectorChangeCollector $rectorChangeCollector, \_PhpScoper0a6b37af0871\Rector\NodeRemoval\NodeRemover $nodeRemover, \_PhpScoper0a6b37af0871\Rector\DeadCode\NodeManipulator\LivingCodeManipulator $livingCodeManipulator)
    {
        $this->nodesToReplaceCollector = $nodesToReplaceCollector;
        $this->rectorChangeCollector = $rectorChangeCollector;
        $this->nodeRemover = $nodeRemover;
        $this->livingCodeManipulator = $livingCodeManipulator;
    }
    public function removeAssignNode(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign $assign) : void
    {
        $currentStatement = $assign->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        $this->livingCodeManipulator->addLivingCodeBeforeNode($assign->var, $currentStatement);
        /** @var Assign $assign */
        $parent = $assign->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression) {
            $this->livingCodeManipulator->addLivingCodeBeforeNode($assign->expr, $currentStatement);
            $this->nodeRemover->removeNode($assign);
        } else {
            $this->nodesToReplaceCollector->addReplaceNodeWithAnotherNode($assign, $assign->expr);
            $this->rectorChangeCollector->notifyNodeFileInfo($assign->expr);
        }
    }
}
