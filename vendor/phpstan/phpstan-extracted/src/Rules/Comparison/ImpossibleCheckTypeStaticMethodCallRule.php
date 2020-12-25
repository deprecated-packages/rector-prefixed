<?php

declare (strict_types=1);
namespace PHPStan\Rules\Comparison;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\ObjectType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\StaticCall>
 */
class ImpossibleCheckTypeStaticMethodCallRule implements \PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\Comparison\ImpossibleCheckTypeHelper */
    private $impossibleCheckTypeHelper;
    /** @var bool */
    private $checkAlwaysTrueCheckTypeFunctionCall;
    /** @var bool */
    private $treatPhpDocTypesAsCertain;
    public function __construct(\PHPStan\Rules\Comparison\ImpossibleCheckTypeHelper $impossibleCheckTypeHelper, bool $checkAlwaysTrueCheckTypeFunctionCall, bool $treatPhpDocTypesAsCertain)
    {
        $this->impossibleCheckTypeHelper = $impossibleCheckTypeHelper;
        $this->checkAlwaysTrueCheckTypeFunctionCall = $checkAlwaysTrueCheckTypeFunctionCall;
        $this->treatPhpDocTypesAsCertain = $treatPhpDocTypesAsCertain;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\StaticCall::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->name instanceof \PhpParser\Node\Identifier) {
            return [];
        }
        $isAlways = $this->impossibleCheckTypeHelper->findSpecifiedType($scope, $node);
        if ($isAlways === null) {
            return [];
        }
        $addTip = function (\PHPStan\Rules\RuleErrorBuilder $ruleErrorBuilder) use($scope, $node) : RuleErrorBuilder {
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
            return [$addTip(\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to static method %s::%s()%s will always evaluate to false.', $method->getDeclaringClass()->getDisplayName(), $method->getName(), $this->impossibleCheckTypeHelper->getArgumentsDescription($scope, $node->args))))->build()];
        } elseif ($this->checkAlwaysTrueCheckTypeFunctionCall) {
            $method = $this->getMethod($node->class, $node->name->name, $scope);
            return [$addTip(\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to static method %s::%s()%s will always evaluate to true.', $method->getDeclaringClass()->getDisplayName(), $method->getName(), $this->impossibleCheckTypeHelper->getArgumentsDescription($scope, $node->args))))->build()];
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
    private function getMethod($class, string $methodName, \PHPStan\Analyser\Scope $scope) : \PHPStan\Reflection\MethodReflection
    {
        if ($class instanceof \PhpParser\Node\Name) {
            $calledOnType = new \PHPStan\Type\ObjectType($scope->resolveName($class));
        } else {
            $calledOnType = $scope->getType($class);
        }
        if (!$calledOnType->hasMethod($methodName)->yes()) {
            throw new \PHPStan\ShouldNotHappenException();
        }
        return $calledOnType->getMethod($methodName, $scope);
    }
}
