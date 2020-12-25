<?php

declare (strict_types=1);
namespace PHPStan\Rules\Methods;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\ErrorType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Expression>
 */
class CallToStaticMethodStamentWithoutSideEffectsRule implements \PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, \PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Stmt\Expression::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->expr instanceof \PhpParser\Node\Expr\StaticCall) {
            return [];
        }
        $staticCall = $node->expr;
        if (!$staticCall->name instanceof \PhpParser\Node\Identifier) {
            return [];
        }
        $methodName = $staticCall->name->toString();
        if ($staticCall->class instanceof \PhpParser\Node\Name) {
            $className = $scope->resolveName($staticCall->class);
            if (!$this->reflectionProvider->hasClass($className)) {
                return [];
            }
            $calledOnType = new \PHPStan\Type\ObjectType($className);
        } else {
            $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $staticCall->class, '', static function (\PHPStan\Type\Type $type) use($methodName) : bool {
                return $type->canCallMethods()->yes() && $type->hasMethod($methodName)->yes();
            });
            $calledOnType = $typeResult->getType();
            if ($calledOnType instanceof \PHPStan\Type\ErrorType) {
                return [];
            }
        }
        if (!$calledOnType->canCallMethods()->yes()) {
            return [];
        }
        if (!$calledOnType->hasMethod($methodName)->yes()) {
            return [];
        }
        $method = $calledOnType->getMethod($methodName, $scope);
        if (\strtolower($method->getName()) === '__construct' || \strtolower($method->getName()) === \strtolower($method->getDeclaringClass()->getName())) {
            return [];
        }
        if ($method->hasSideEffects()->no()) {
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to %s %s::%s() on a separate line has no effect.', $method->isStatic() ? 'static method' : 'method', $method->getDeclaringClass()->getDisplayName(), $method->getName()))->build()];
        }
        return [];
    }
}
