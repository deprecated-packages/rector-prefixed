<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Comparison;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\BinaryOp\BooleanOr>
 */
class BooleanOrConstantConditionRule implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Rule
{
    /** @var ConstantConditionRuleHelper */
    private $helper;
    /** @var bool */
    private $treatPhpDocTypesAsCertain;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Comparison\ConstantConditionRuleHelper $helper, bool $treatPhpDocTypesAsCertain)
    {
        $this->helper = $helper;
        $this->treatPhpDocTypesAsCertain = $treatPhpDocTypesAsCertain;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\BooleanOr::class;
    }
    public function processNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : array
    {
        $messages = [];
        $leftType = $this->helper->getBooleanType($scope, $node->left);
        $tipText = 'Because the type is coming from a PHPDoc, you can turn off this check by setting <fg=cyan>treatPhpDocTypesAsCertain: false</> in your <fg=cyan>%configurationFile%</>.';
        if ($leftType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType) {
            $addTipLeft = function (\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder $ruleErrorBuilder) use($scope, $node, $tipText) : RuleErrorBuilder {
                if (!$this->treatPhpDocTypesAsCertain) {
                    return $ruleErrorBuilder;
                }
                $booleanNativeType = $this->helper->getNativeBooleanType($scope, $node->left);
                if ($booleanNativeType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType) {
                    return $ruleErrorBuilder;
                }
                return $ruleErrorBuilder->tip($tipText);
            };
            $messages[] = $addTipLeft(\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Left side of || is always %s.', $leftType->getValue() ? 'true' : 'false')))->line($node->left->getLine())->build();
        }
        $rightType = $this->helper->getBooleanType($scope->filterByFalseyValue($node->left), $node->right);
        if ($rightType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType) {
            $addTipRight = function (\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder $ruleErrorBuilder) use($scope, $node, $tipText) : RuleErrorBuilder {
                if (!$this->treatPhpDocTypesAsCertain) {
                    return $ruleErrorBuilder;
                }
                $booleanNativeType = $this->helper->getNativeBooleanType($scope->doNotTreatPhpDocTypesAsCertain()->filterByFalseyValue($node->left), $node->right);
                if ($booleanNativeType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType) {
                    return $ruleErrorBuilder;
                }
                return $ruleErrorBuilder->tip($tipText);
            };
            $messages[] = $addTipRight(\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Right side of || is always %s.', $rightType->getValue() ? 'true' : 'false')))->line($node->right->getLine())->build();
        }
        if (\count($messages) === 0) {
            $nodeType = $scope->getType($node);
            if ($nodeType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType) {
                $addTip = function (\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder $ruleErrorBuilder) use($scope, $node, $tipText) : RuleErrorBuilder {
                    if (!$this->treatPhpDocTypesAsCertain) {
                        return $ruleErrorBuilder;
                    }
                    $booleanNativeType = $scope->doNotTreatPhpDocTypesAsCertain()->getType($node);
                    if ($booleanNativeType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType) {
                        return $ruleErrorBuilder;
                    }
                    return $ruleErrorBuilder->tip($tipText);
                };
                $messages[] = $addTip(\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Result of || is always %s.', $nodeType->getValue() ? 'true' : 'false')))->build();
            }
        }
        return $messages;
    }
}
