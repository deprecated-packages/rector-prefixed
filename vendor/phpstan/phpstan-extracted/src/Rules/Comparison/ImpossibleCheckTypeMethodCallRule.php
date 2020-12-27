<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Comparison;

use PhpParser\Node;
use PhpParser\Node\Expr;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\MethodCall>
 */
class ImpossibleCheckTypeMethodCallRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\Comparison\ImpossibleCheckTypeHelper */
    private $impossibleCheckTypeHelper;
    /** @var bool */
    private $checkAlwaysTrueCheckTypeFunctionCall;
    /** @var bool */
    private $treatPhpDocTypesAsCertain;
    public function __construct(\RectorPrefix20201227\PHPStan\Rules\Comparison\ImpossibleCheckTypeHelper $impossibleCheckTypeHelper, bool $checkAlwaysTrueCheckTypeFunctionCall, bool $treatPhpDocTypesAsCertain)
    {
        $this->impossibleCheckTypeHelper = $impossibleCheckTypeHelper;
        $this->checkAlwaysTrueCheckTypeFunctionCall = $checkAlwaysTrueCheckTypeFunctionCall;
        $this->treatPhpDocTypesAsCertain = $treatPhpDocTypesAsCertain;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\MethodCall::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->name instanceof \PhpParser\Node\Identifier) {
            return [];
        }
        $isAlways = $this->impossibleCheckTypeHelper->findSpecifiedType($scope, $node);
        if ($isAlways === null) {
            return [];
        }
        $addTip = function (\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder $ruleErrorBuilder) use($scope, $node) : RuleErrorBuilder {
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
            $method = $this->getMethod($node->var, $node->name->name, $scope);
            return [$addTip(\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to method %s::%s()%s will always evaluate to false.', $method->getDeclaringClass()->getDisplayName(), $method->getName(), $this->impossibleCheckTypeHelper->getArgumentsDescription($scope, $node->args))))->build()];
        } elseif ($this->checkAlwaysTrueCheckTypeFunctionCall) {
            $method = $this->getMethod($node->var, $node->name->name, $scope);
            return [$addTip(\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to method %s::%s()%s will always evaluate to true.', $method->getDeclaringClass()->getDisplayName(), $method->getName(), $this->impossibleCheckTypeHelper->getArgumentsDescription($scope, $node->args))))->build()];
        }
        return [];
    }
    private function getMethod(\PhpParser\Node\Expr $var, string $methodName, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : \RectorPrefix20201227\PHPStan\Reflection\MethodReflection
    {
        $calledOnType = $scope->getType($var);
        if (!$calledOnType->hasMethod($methodName)->yes()) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        return $calledOnType->getMethod($methodName, $scope);
    }
}
