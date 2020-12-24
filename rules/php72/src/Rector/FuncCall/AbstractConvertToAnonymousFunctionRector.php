<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php72\Rector\FuncCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ClosureUse;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\Php72\Contract\ConvertToAnonymousFunctionRectorInterface;
/**
 * @see https://www.php.net/functions.anonymous
 */
abstract class AbstractConvertToAnonymousFunctionRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a6b37af0871\Rector\Php72\Contract\ConvertToAnonymousFunctionRectorInterface
{
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        $body = $this->getBody($node);
        $parameters = $this->getParameters($node);
        $useVariables = $this->resolveUseVariables($body, $parameters);
        $anonymousFunctionNode = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure();
        $anonymousFunctionNode->params = $parameters;
        foreach ($useVariables as $useVariable) {
            $anonymousFunctionNode->uses[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ClosureUse($useVariable);
        }
        $anonymousFunctionNode->returnType = $this->getReturnType($node);
        if ($body !== []) {
            $anonymousFunctionNode->stmts = $body;
        }
        return $anonymousFunctionNode;
    }
    /**
     * @param Node[] $nodes
     * @param Param[] $paramNodes
     * @return Variable[]
     */
    private function resolveUseVariables(array $nodes, array $paramNodes) : array
    {
        $paramNames = [];
        foreach ($paramNodes as $paramNode) {
            $paramNames[] = $this->getName($paramNode);
        }
        $variableNodes = $this->betterNodeFinder->findInstanceOf($nodes, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable::class);
        /** @var Variable[] $filteredVariables */
        $filteredVariables = [];
        $alreadyAssignedVariables = [];
        foreach ($variableNodes as $variableNode) {
            // "$this" is allowed
            if ($this->isName($variableNode, 'this')) {
                continue;
            }
            $variableName = $this->getName($variableNode);
            if ($variableName === null) {
                continue;
            }
            if (\in_array($variableName, $paramNames, \true)) {
                continue;
            }
            $parentNode = $variableNode->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign) {
                $alreadyAssignedVariables[] = $variableName;
            }
            if ($this->isNames($variableNode, $alreadyAssignedVariables)) {
                continue;
            }
            $filteredVariables[$variableName] = $variableNode;
        }
        return $filteredVariables;
    }
}
