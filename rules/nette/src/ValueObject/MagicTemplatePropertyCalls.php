<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Nette\ValueObject;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
final class MagicTemplatePropertyCalls
{
    /**
     * @var Node[]
     */
    private $nodesToRemove = [];
    /**
     * @var Expr[]
     */
    private $templateVariables = [];
    /**
     * @var Expr|null
     */
    private $templateFileExpr;
    /**
     * @param Expr[] $templateVariables
     * @param Node[] $nodesToRemove
     */
    public function __construct(?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $templateFileExpr, array $templateVariables, array $nodesToRemove)
    {
        $this->templateFileExpr = $templateFileExpr;
        $this->templateVariables = $templateVariables;
        $this->nodesToRemove = $nodesToRemove;
    }
    public function getTemplateFileExpr() : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr
    {
        return $this->templateFileExpr;
    }
    /**
     * @return Expr[]
     */
    public function getTemplateVariables() : array
    {
        return $this->templateVariables;
    }
    /**
     * @return Node[]
     */
    public function getNodesToRemove() : array
    {
        return $this->nodesToRemove;
    }
}
