<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeCorrector;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Rector\NodeNestingScope\ParentScopeFinder;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\NodeNestingScope\ParentScopeFinder $parentScopeFinder)
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
    public function correct(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $originalType) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable) {
            return $originalType;
        }
        if ($originalType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType) {
            return $originalType;
        }
        $variableUsages = $this->getVariableUsages($node);
        foreach ($variableUsages as $variableUsage) {
            $possiblyArg = $variableUsage->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if (!$possiblyArg instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Arg) {
                continue;
            }
            $funcCallNode = $possiblyArg->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if (!$funcCallNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall) {
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
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType());
        }
        return $originalType;
    }
    /**
     * @return Node[]
     */
    private function getVariableUsages(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable $variable) : array
    {
        $scope = $this->parentScopeFinder->find($variable);
        if ($scope === null) {
            return [];
        }
        return $this->betterNodeFinder->find((array) $scope->stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use($variable) : bool {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable) {
                return \false;
            }
            return $node->name === $variable->name;
        });
    }
}
