<?php

declare (strict_types=1);
namespace PHPStan\Rules\Functions;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\FunctionCallParametersCheck;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\FuncCall>
 */
class CallToFunctionParametersRule implements \PHPStan\Rules\Rule
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Rules\FunctionCallParametersCheck */
    private $check;
    public function __construct(\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \PHPStan\Rules\FunctionCallParametersCheck $check)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->check = $check;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\FuncCall::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->name instanceof \PhpParser\Node\Name) {
            return [];
        }
        if (!$this->reflectionProvider->hasFunction($node->name, $scope)) {
            return [];
        }
        $function = $this->reflectionProvider->getFunction($node->name, $scope);
        return $this->check->check(\PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $node->args, $function->getVariants()), $scope, $function->isBuiltin(), $node, ['Function ' . $function->getName() . ' invoked with %d parameter, %d required.', 'Function ' . $function->getName() . ' invoked with %d parameters, %d required.', 'Function ' . $function->getName() . ' invoked with %d parameter, at least %d required.', 'Function ' . $function->getName() . ' invoked with %d parameters, at least %d required.', 'Function ' . $function->getName() . ' invoked with %d parameter, %d-%d required.', 'Function ' . $function->getName() . ' invoked with %d parameters, %d-%d required.', 'Parameter %s of function ' . $function->getName() . ' expects %s, %s given.', 'Result of function ' . $function->getName() . ' (void) is used.', 'Parameter %s of function ' . $function->getName() . ' is passed by reference, so it expects variables only.', 'Unable to resolve the template type %s in call to function ' . $function->getName(), 'Missing parameter $%s in call to function ' . $function->getName() . '.', 'Unknown parameter $%s in call to function ' . $function->getName() . '.']);
    }
}
