<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Comparison;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Ternary>
 */
class UnreachableTernaryElseBranchRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var ConstantConditionRuleHelper */
    private $helper;
    /** @var bool */
    private $treatPhpDocTypesAsCertain;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\Comparison\ConstantConditionRuleHelper $helper, bool $treatPhpDocTypesAsCertain)
    {
        $this->helper = $helper;
        $this->treatPhpDocTypesAsCertain = $treatPhpDocTypesAsCertain;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr\Ternary::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $conditionType = $scope->getType($node->cond)->toBoolean();
        if ($conditionType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType && $conditionType->getValue() && $this->helper->shouldSkip($scope, $node->cond) && !$this->helper->shouldReportAlwaysTrueByDefault($node->cond)) {
            $addTip = function (\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder $ruleErrorBuilder) use($scope, $node) : RuleErrorBuilder {
                if (!$this->treatPhpDocTypesAsCertain) {
                    return $ruleErrorBuilder;
                }
                $booleanNativeType = $scope->doNotTreatPhpDocTypesAsCertain()->getType($node->cond);
                if ($booleanNativeType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType) {
                    return $ruleErrorBuilder;
                }
                return $ruleErrorBuilder->tip('Because the type is coming from a PHPDoc, you can turn off this check by setting <fg=cyan>treatPhpDocTypesAsCertain: false</> in your <fg=cyan>%configurationFile%</>.');
            };
            return [$addTip(\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message('Else branch is unreachable because ternary operator condition is always true.'))->line($node->else->getLine())->identifier('deadCode.unreachableTernaryElse')->metadata(['statementDepth' => $node->getAttribute('statementDepth'), 'statementOrder' => $node->getAttribute('statementOrder'), 'depth' => $node->getAttribute('expressionDepth'), 'order' => $node->getAttribute('expressionOrder')])->build()];
        }
        return [];
    }
}
