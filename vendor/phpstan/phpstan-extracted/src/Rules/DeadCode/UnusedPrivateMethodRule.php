<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\DeadCode;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Node\ClassMethodsNode;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Rules\Rule;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils;
/**
 * @implements Rule<ClassMethodsNode>
 */
class UnusedPrivateMethodRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Node\ClassMethodsNode::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->getClass() instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
            return [];
        }
        if (!$scope->isInClass()) {
            throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
        }
        $classReflection = $scope->getClassReflection();
        $constructor = null;
        if ($classReflection->hasConstructor()) {
            $constructor = $classReflection->getConstructor();
        }
        $classType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($classReflection->getName());
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
            if ($methodCallNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_) {
                $arrayCalls[] = $methodCall;
                continue;
            }
            $callScope = $methodCall->getScope();
            if ($methodCallNode->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier) {
                $methodNames = [$methodCallNode->name->toString()];
            } else {
                $methodNameType = $callScope->getType($methodCallNode->name);
                $strings = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::getConstantStrings($methodNameType);
                if (\count($strings) === 0) {
                    return [];
                }
                $methodNames = \array_map(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType $type) : string {
                    return $type->getValue();
                }, $strings);
            }
            if ($methodCallNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
                $calledOnType = $callScope->getType($methodCallNode->var);
            } else {
                if (!$methodCallNode->class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
                    continue;
                }
                $calledOnType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($callScope->resolveName($methodCallNode->class));
            }
            if ($classType->isSuperTypeOf($calledOnType)->no()) {
                continue;
            }
            if ($calledOnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
                continue;
            }
            $inMethod = $callScope->getFunction();
            if (!$inMethod instanceof \_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection) {
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
                if (!$arrayType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType) {
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
                if ($calledOnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
                    continue;
                }
                $inMethod = $arrayScope->getFunction();
                if (!$inMethod instanceof \_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection) {
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
            $errors[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s %s::%s() is unused.', $methodType, $classReflection->getDisplayName(), $methodName))->line($methodNode->getLine())->identifier('deadCode.unusedMethod')->metadata(['classOrder' => $node->getClass()->getAttribute('statementOrder'), 'classDepth' => $node->getClass()->getAttribute('statementDepth'), 'classStartLine' => $node->getClass()->getStartLine(), 'methodName' => $methodName])->build();
        }
        return $errors;
    }
}
