<?php

declare (strict_types=1);
namespace Rector\Php72\Rector\FuncCall;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\ClosureUse;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\Php72\Contract\ConvertToAnonymousFunctionRectorInterface;
/**
 * @see https://www.php.net/functions.anonymous
 */
abstract class AbstractConvertToAnonymousFunctionRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Php72\Contract\ConvertToAnonymousFunctionRectorInterface
{
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        $body = $this->getBody($node);
        $parameters = $this->getParameters($node);
        $useVariables = $this->resolveUseVariables($body, $parameters);
        $anonymousFunctionNode = new \PhpParser\Node\Expr\Closure();
        $anonymousFunctionNode->params = $parameters;
        foreach ($useVariables as $useVariable) {
            $anonymousFunctionNode->uses[] = new \PhpParser\Node\Expr\ClosureUse($useVariable);
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
        $variableNodes = $this->betterNodeFinder->findInstanceOf($nodes, \PhpParser\Node\Expr\Variable::class);
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
            $parentNode = $variableNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentNode instanceof \PhpParser\Node\Expr\Assign) {
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
