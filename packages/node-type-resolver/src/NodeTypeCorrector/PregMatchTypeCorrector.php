<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeCorrector;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeNestingScope\ParentScopeFinder;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class PregMatchTypeCorrector
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    /**
     * @var ParentScopeFinder
     */
    private $parentScopeFinder;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\NodeNestingScope\ParentScopeFinder $parentScopeFinder)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->parentScopeFinder = $parentScopeFinder;
    }
    /**
     * Special case for "preg_match(), preg_match_all()" - with 3rd argument
     * @see https://github.com/rectorphp/rector/issues/786
     */
    public function correct(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Type\Type $originalType) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
            return $originalType;
        }
        if ($originalType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
            return $originalType;
        }
        $variableUsages = $this->getVariableUsages($node);
        foreach ($variableUsages as $variableUsage) {
            $possiblyArg = $variableUsage->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if (!$possiblyArg instanceof \_PhpScopere8e811afab72\PhpParser\Node\Arg) {
                continue;
            }
            $funcCallNode = $possiblyArg->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if (!$funcCallNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall) {
                continue;
            }
            if (!$this->nodeNameResolver->isNames($funcCallNode, ['preg_match', 'preg_match_all'])) {
                continue;
            }
            if (!isset($funcCallNode->args[2])) {
                continue;
            }
            // are the same variables
            if (!$this->betterStandardPrinter->areNodesEqual($funcCallNode->args[2]->value, $node)) {
                continue;
            }
            return new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), new \_PhpScopere8e811afab72\PHPStan\Type\MixedType());
        }
        return $originalType;
    }
    /**
     * @return Node[]
     */
    private function getVariableUsages(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $variable) : array
    {
        $scope = $this->parentScopeFinder->find($variable);
        if ($scope === null) {
            return [];
        }
        return $this->betterNodeFinder->find((array) $scope->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($variable) : bool {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
                return \false;
            }
            return $node->name === $variable->name;
        });
    }
}
