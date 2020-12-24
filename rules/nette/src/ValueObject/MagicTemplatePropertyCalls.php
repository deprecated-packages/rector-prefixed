<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Nette\ValueObject;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
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
    public function __construct(?\_PhpScopere8e811afab72\PhpParser\Node\Expr $templateFileExpr, array $templateVariables, array $nodesToRemove)
    {
        $this->templateFileExpr = $templateFileExpr;
        $this->templateVariables = $templateVariables;
        $this->nodesToRemove = $nodesToRemove;
    }
    public function getTemplateFileExpr() : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr
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
