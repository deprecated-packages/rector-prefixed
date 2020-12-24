<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Variables;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Variable>
 */
class DefinedVariableRule implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Rule
{
    /** @var bool */
    private $cliArgumentsVariablesRegistered;
    /** @var bool */
    private $checkMaybeUndefinedVariables;
    public function __construct(bool $cliArgumentsVariablesRegistered, bool $checkMaybeUndefinedVariables)
    {
        $this->cliArgumentsVariablesRegistered = $cliArgumentsVariablesRegistered;
        $this->checkMaybeUndefinedVariables = $checkMaybeUndefinedVariables;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable::class;
    }
    public function processNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : array
    {
        if (!\is_string($node->name)) {
            return [];
        }
        if ($this->cliArgumentsVariablesRegistered && \in_array($node->name, ['argc', 'argv'], \true)) {
            $isInMain = !$scope->isInClass() && !$scope->isInAnonymousFunction() && $scope->getFunction() === null;
            if ($isInMain) {
                return [];
            }
        }
        if ($scope->isInExpressionAssign($node)) {
            return [];
        }
        if ($scope->hasVariableType($node->name)->no()) {
            return [\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Undefined variable: $%s', $node->name))->identifier('variable.undefined')->metadata(['variableName' => $node->name, 'statementDepth' => $node->getAttribute('statementDepth'), 'statementOrder' => $node->getAttribute('statementOrder'), 'depth' => $node->getAttribute('expressionDepth'), 'order' => $node->getAttribute('expressionOrder'), 'variables' => $scope->getDefinedVariables(), 'parentVariables' => $this->getParentVariables($scope)])->build()];
        } elseif ($this->checkMaybeUndefinedVariables && !$scope->hasVariableType($node->name)->yes()) {
            return [\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Variable $%s might not be defined.', $node->name))->identifier('variable.maybeUndefined')->metadata(['variableName' => $node->name, 'statementDepth' => $node->getAttribute('statementDepth'), 'statementOrder' => $node->getAttribute('statementOrder'), 'depth' => $node->getAttribute('expressionDepth'), 'order' => $node->getAttribute('expressionOrder'), 'variables' => $scope->getDefinedVariables(), 'parentVariables' => $this->getParentVariables($scope)])->build()];
        }
        return [];
    }
    /**
     * @param Scope $scope
     * @return array<int, array<int, string>>
     */
    private function getParentVariables(\_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : array
    {
        $variables = [];
        $parent = $scope->getParentScope();
        while ($parent !== null) {
            $variables[] = $parent->getDefinedVariables();
            $parent = $parent->getParentScope();
        }
        return $variables;
    }
}
