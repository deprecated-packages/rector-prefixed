<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Comparison;

use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\Constant\ConstantBooleanType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Ternary>
 */
class TernaryOperatorConstantConditionRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var ConstantConditionRuleHelper */
    private $helper;
    /** @var bool */
    private $treatPhpDocTypesAsCertain;
    public function __construct(\RectorPrefix20201227\PHPStan\Rules\Comparison\ConstantConditionRuleHelper $helper, bool $treatPhpDocTypesAsCertain)
    {
        $this->helper = $helper;
        $this->treatPhpDocTypesAsCertain = $treatPhpDocTypesAsCertain;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\Ternary::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        $exprType = $this->helper->getBooleanType($scope, $node->cond);
        if ($exprType instanceof \PHPStan\Type\Constant\ConstantBooleanType) {
            $addTip = function (\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder $ruleErrorBuilder) use($scope, $node) : RuleErrorBuilder {
                if (!$this->treatPhpDocTypesAsCertain) {
                    return $ruleErrorBuilder;
                }
                $booleanNativeType = $this->helper->getNativeBooleanType($scope, $node->cond);
                if ($booleanNativeType instanceof \PHPStan\Type\Constant\ConstantBooleanType) {
                    return $ruleErrorBuilder;
                }
                return $ruleErrorBuilder->tip('Because the type is coming from a PHPDoc, you can turn off this check by setting <fg=cyan>treatPhpDocTypesAsCertain: false</> in your <fg=cyan>%configurationFile%</>.');
            };
            return [$addTip(\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Ternary operator condition is always %s.', $exprType->getValue() ? 'true' : 'false')))->identifier('deadCode.ternaryConstantCondition')->metadata(['statementDepth' => $node->getAttribute('statementDepth'), 'statementOrder' => $node->getAttribute('statementOrder'), 'depth' => $node->getAttribute('expressionDepth'), 'order' => $node->getAttribute('expressionOrder'), 'value' => $exprType->getValue()])->build()];
        }
        return [];
    }
}
