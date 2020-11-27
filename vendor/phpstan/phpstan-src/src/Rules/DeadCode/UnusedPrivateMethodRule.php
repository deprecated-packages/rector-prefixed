<?php

declare (strict_types=1);
namespace PHPStan\Rules\DeadCode;

use PhpParser\Node;
use PhpParser\Node\Identifier;
use PHPStan\Analyser\Scope;
use PHPStan\Node\ClassMethodsNode;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\TypeUtils;
/**
 * @implements Rule<ClassMethodsNode>
 */
class UnusedPrivateMethodRule implements \PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \PHPStan\Node\ClassMethodsNode::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->getClass() instanceof \PhpParser\Node\Stmt\Class_) {
            return [];
        }
        if (!$scope->isInClass()) {
            throw new \PHPStan\ShouldNotHappenException();
        }
        $classReflection = $scope->getClassReflection();
        $constructor = null;
        if ($classReflection->hasConstructor()) {
            $constructor = $classReflection->getConstructor();
        }
        $classType = new \PHPStan\Type\ObjectType($classReflection->getName());
        $methods = [];
        foreach ($node->getMethods() as $method) {
            if (!$method->isPrivate()) {
                continue;
            }
            $methodName = $method->name->toString();
            if ($constructor !== null && $constructor->getName() === $methodName) {
                continue;
            }
            if (\strtolower($methodName) === '__clone') {
                continue;
            }
            $methods[$method->name->toString()] = $method;
        }
        $arrayCalls = [];
        foreach ($node->getMethodCalls() as $methodCall) {
            $methodCallNode = $methodCall->getNode();
            if ($methodCallNode instanceof \PhpParser\Node\Expr\Array_) {
                $arrayCalls[] = $methodCall;
                continue;
            }
            $callScope = $methodCall->getScope();
            if ($methodCallNode->name instanceof \PhpParser\Node\Identifier) {
                $methodNames = [$methodCallNode->name->toString()];
            } else {
                $methodNameType = $callScope->getType($methodCallNode->name);
                $strings = \PHPStan\Type\TypeUtils::getConstantStrings($methodNameType);
                if (\count($strings) === 0) {
                    return [];
                }
                $methodNames = \array_map(static function (\PHPStan\Type\Constant\ConstantStringType $type) : string {
                    return $type->getValue();
                }, $strings);
            }
            if ($methodCallNode instanceof \PhpParser\Node\Expr\MethodCall) {
                $calledOnType = $callScope->getType($methodCallNode->var);
            } else {
                if (!$methodCallNode->class instanceof \PhpParser\Node\Name) {
                    continue;
                }
                $calledOnType = new \PHPStan\Type\ObjectType($callScope->resolveName($methodCallNode->class));
            }
            if ($classType->isSuperTypeOf($calledOnType)->no()) {
                continue;
            }
            if ($calledOnType instanceof \PHPStan\Type\MixedType) {
                continue;
            }
            $inMethod = $callScope->getFunction();
            if (!$inMethod instanceof \PHPStan\Reflection\MethodReflection) {
                continue;
            }
            foreach ($methodNames as $methodName) {
                if ($inMethod->getName() === $methodName) {
                    continue;
                }
                unset($methods[$methodName]);
            }
        }
        if (\count($methods) > 0) {
            foreach ($arrayCalls as $arrayCall) {
                /** @var Node\Expr\Array_ $array */
                $array = $arrayCall->getNode();
                $arrayScope = $arrayCall->getScope();
                $arrayType = $scope->getType($array);
                if (!$arrayType instanceof \PHPStan\Type\Constant\ConstantArrayType) {
                    continue;
                }
                $typeAndMethod = $arrayType->findTypeAndMethodName();
                if ($typeAndMethod === null) {
                    continue;
                }
                if ($typeAndMethod->isUnknown()) {
                    return [];
                }
                if (!$typeAndMethod->getCertainty()->yes()) {
                    return [];
                }
                $calledOnType = $typeAndMethod->getType();
                if ($classType->isSuperTypeOf($calledOnType)->no()) {
                    continue;
                }
                if ($calledOnType instanceof \PHPStan\Type\MixedType) {
                    continue;
                }
                $inMethod = $arrayScope->getFunction();
                if (!$inMethod instanceof \PHPStan\Reflection\MethodReflection) {
                    continue;
                }
                if ($inMethod->getName() === $typeAndMethod->getMethod()) {
                    continue;
                }
                unset($methods[$typeAndMethod->getMethod()]);
            }
        }
        $errors = [];
        foreach ($methods as $methodName => $methodNode) {
            $methodType = 'Method';
            if ($methodNode->isStatic()) {
                $methodType = 'Static method';
            }
            $errors[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s %s::%s() is unused.', $methodType, $classReflection->getDisplayName(), $methodName))->line($methodNode->getLine())->identifier('deadCode.unusedMethod')->metadata(['classOrder' => $node->getClass()->getAttribute('statementOrder'), 'classDepth' => $node->getClass()->getAttribute('statementDepth'), 'classStartLine' => $node->getClass()->getStartLine(), 'methodName' => $methodName])->build();
        }
        return $errors;
    }
}
