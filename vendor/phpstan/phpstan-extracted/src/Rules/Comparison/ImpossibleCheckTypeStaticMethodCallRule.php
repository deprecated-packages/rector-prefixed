<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Comparison;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\StaticCall>
 */
class ImpossibleCheckTypeStaticMethodCallRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\Comparison\ImpossibleCheckTypeHelper */
    private $impossibleCheckTypeHelper;
    /** @var bool */
    private $checkAlwaysTrueCheckTypeFunctionCall;
    /** @var bool */
    private $treatPhpDocTypesAsCertain;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\Comparison\ImpossibleCheckTypeHelper $impossibleCheckTypeHelper, bool $checkAlwaysTrueCheckTypeFunctionCall, bool $treatPhpDocTypesAsCertain)
    {
        $this->impossibleCheckTypeHelper = $impossibleCheckTypeHelper;
        $this->checkAlwaysTrueCheckTypeFunctionCall = $checkAlwaysTrueCheckTypeFunctionCall;
        $this->treatPhpDocTypesAsCertain = $treatPhpDocTypesAsCertain;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Identifier) {
            return [];
        }
        $isAlways = $this->impossibleCheckTypeHelper->findSpecifiedType($scope, $node);
        if ($isAlways === null) {
            return [];
        }
        $addTip = function (\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder $ruleErrorBuilder) use($scope, $node) : RuleErrorBuilder {
            if (!$this->treatPhpDocTypesAsCertain) {
                return $ruleErrorBuilder;
            }
            $isAlways = $this->impossibleCheckTypeHelper->doNotTreatPhpDocTypesAsCertain()->findSpecifiedType($scope, $node);
            if ($isAlways !== null) {
                return $ruleErrorBuilder;
            }
            return $ruleErrorBuilder->tip('Because the type is coming from a PHPDoc, you can turn off this check by setting <fg=cyan>treatPhpDocTypesAsCertain: false</> in your <fg=cyan>%configurationFile%</>.');
        };
        if (!$isAlways) {
            $method = $this->getMethod($node->class, $node->name->name, $scope);
            return [$addTip(\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to static method %s::%s()%s will always evaluate to false.', $method->getDeclaringClass()->getDisplayName(), $method->getName(), $this->impossibleCheckTypeHelper->getArgumentsDescription($scope, $node->args))))->build()];
        } elseif ($this->checkAlwaysTrueCheckTypeFunctionCall) {
            $method = $this->getMethod($node->class, $node->name->name, $scope);
            return [$addTip(\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to static method %s::%s()%s will always evaluate to true.', $method->getDeclaringClass()->getDisplayName(), $method->getName(), $this->impossibleCheckTypeHelper->getArgumentsDescription($scope, $node->args))))->build()];
        }
        return [];
    }
    /**
     * @param Node\Name|Expr $class
     * @param string $methodName
     * @param Scope $scope
     * @return MethodReflection
     * @throws \PHPStan\ShouldNotHappenException
     */
    private function getMethod($class, string $methodName, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection
    {
        if ($class instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
            $calledOnType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($scope->resolveName($class));
        } else {
            $calledOnType = $scope->getType($class);
        }
        if (!$calledOnType->hasMethod($methodName)->yes()) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        return $calledOnType->getMethod($methodName, $scope);
    }
}
