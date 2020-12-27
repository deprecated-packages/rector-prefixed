<?php

declare (strict_types=1);
namespace PHPStan\Rules\Comparison;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\Constant\ConstantBooleanType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Ternary>
 */
class UnreachableTernaryElseBranchRule implements \PHPStan\Rules\Rule
{
    /** @var ConstantConditionRuleHelper */
    private $helper;
    /** @var bool */
    private $treatPhpDocTypesAsCertain;
    public function __construct(\PHPStan\Rules\Comparison\ConstantConditionRuleHelper $helper, bool $treatPhpDocTypesAsCertain)
    {
        $this->helper = $helper;
        $this->treatPhpDocTypesAsCertain = $treatPhpDocTypesAsCertain;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\Ternary::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $conditionType = $scope->getType($node->cond)->toBoolean();
        if ($conditionType instanceof \PHPStan\Type\Constant\ConstantBooleanType && $conditionType->getValue() && $this->helper->shouldSkip($scope, $node->cond) && !$this->helper->shouldReportAlwaysTrueByDefault($node->cond)) {
            $addTip = function (\PHPStan\Rules\RuleErrorBuilder $ruleErrorBuilder) use($scope, $node) : RuleErrorBuilder {
                if (!$this->treatPhpDocTypesAsCertain) {
                    return $ruleErrorBuilder;
                }
                $booleanNativeType = $scope->doNotTreatPhpDocTypesAsCertain()->getType($node->cond);
                if ($booleanNativeType instanceof \PHPStan\Type\Constant\ConstantBooleanType) {
                    return $ruleErrorBuilder;
                }
                return $ruleErrorBuilder->tip('Because the type is coming from a PHPDoc, you can turn off this check by setting <fg=cyan>treatPhpDocTypesAsCertain: false</> in your <fg=cyan>%configurationFile%</>.');
            };
            return [$addTip(\PHPStan\Rules\RuleErrorBuilder::message('Else branch is unreachable because ternary operator condition is always true.'))->line($node->else->getLine())->identifier('deadCode.unreachableTernaryElse')->metadata(['statementDepth' => $node->getAttribute('statementDepth'), 'statementOrder' => $node->getAttribute('statementOrder'), 'depth' => $node->getAttribute('expressionDepth'), 'order' => $node->getAttribute('expressionOrder')])->build()];
        }
        return [];
    }
}
