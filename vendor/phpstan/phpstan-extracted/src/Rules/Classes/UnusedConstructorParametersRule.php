<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\Classes;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Param;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Node\InClassMethodNode;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\UnusedFunctionParametersCheck;
/**
 * @implements \PHPStan\Rules\Rule<InClassMethodNode>
 */
class UnusedConstructorParametersRule implements \_PhpScoper0a2ac50786fa\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\UnusedFunctionParametersCheck */
    private $check;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Rules\UnusedFunctionParametersCheck $check)
    {
        $this->check = $check;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\Node\InClassMethodNode::class;
    }
    public function processNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->isInClass()) {
            throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
        }
        $method = $scope->getFunction();
        if (!$method instanceof \_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection) {
            return [];
        }
        $originalNode = $node->getOriginalNode();
        if (\strtolower($method->getName()) !== '__construct' || $originalNode->stmts === null) {
            return [];
        }
        if (\count($originalNode->params) === 0) {
            return [];
        }
        $message = \sprintf('Constructor of class %s has an unused parameter $%%s.', $scope->getClassReflection()->getDisplayName());
        if ($scope->getClassReflection()->isAnonymous()) {
            $message = 'Constructor of an anonymous class has an unused parameter $%s.';
        }
        return $this->check->getUnusedParameters($scope, \array_map(static function (\_PhpScoper0a2ac50786fa\PhpParser\Node\Param $parameter) : string {
            if (!$parameter->var instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable || !\is_string($parameter->var->name)) {
                throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
            }
            return $parameter->var->name;
        }, \array_values(\array_filter($originalNode->params, static function (\_PhpScoper0a2ac50786fa\PhpParser\Node\Param $parameter) : bool {
            return $parameter->flags === 0;
        }))), $originalNode->stmts, $message, 'constructor.unusedParameter', []);
    }
}
