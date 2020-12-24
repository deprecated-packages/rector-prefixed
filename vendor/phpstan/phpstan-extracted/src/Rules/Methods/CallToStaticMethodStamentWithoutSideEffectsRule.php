<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Methods;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleLevelHelper;
use _PhpScopere8e811afab72\PHPStan\Type\ErrorType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Expression>
 */
class CallToStaticMethodStamentWithoutSideEffectsRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, \_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
            return [];
        }
        $staticCall = $node->expr;
        if (!$staticCall->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Identifier) {
            return [];
        }
        $methodName = $staticCall->name->toString();
        if ($staticCall->class instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
            $className = $scope->resolveName($staticCall->class);
            if (!$this->reflectionProvider->hasClass($className)) {
                return [];
            }
            $calledOnType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($className);
        } else {
            $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $staticCall->class, '', static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) use($methodName) : bool {
                return $type->canCallMethods()->yes() && $type->hasMethod($methodName)->yes();
            });
            $calledOnType = $typeResult->getType();
            if ($calledOnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType) {
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
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to %s %s::%s() on a separate line has no effect.', $method->isStatic() ? 'static method' : 'method', $method->getDeclaringClass()->getDisplayName(), $method->getName()))->build()];
        }
        return [];
    }
}
