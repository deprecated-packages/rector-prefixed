<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Classes;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\StringType;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Instanceof_>
 */
class ImpossibleInstanceOfRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var bool */
    private $checkAlwaysTrueInstanceof;
    /** @var bool */
    private $treatPhpDocTypesAsCertain;
    public function __construct(bool $checkAlwaysTrueInstanceof, bool $treatPhpDocTypesAsCertain)
    {
        $this->checkAlwaysTrueInstanceof = $checkAlwaysTrueInstanceof;
        $this->treatPhpDocTypesAsCertain = $treatPhpDocTypesAsCertain;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\Instanceof_::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        $instanceofType = $scope->getType($node);
        $expressionType = $scope->getType($node->expr);
        if ($node->class instanceof \PhpParser\Node\Name) {
            $className = $scope->resolveName($node->class);
            $classType = new \PHPStan\Type\ObjectType($className);
        } else {
            $classType = $scope->getType($node->class);
            $allowed = \PHPStan\Type\TypeCombinator::union(new \PHPStan\Type\StringType(), new \PHPStan\Type\ObjectWithoutClassType());
            if (!$allowed->accepts($classType, \true)->yes()) {
                return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Instanceof between %s and %s results in an error.', $expressionType->describe(\PHPStan\Type\VerbosityLevel::typeOnly()), $classType->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
            }
        }
        if (!$instanceofType instanceof \PHPStan\Type\Constant\ConstantBooleanType) {
            return [];
        }
        $addTip = function (\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder $ruleErrorBuilder) use($scope, $node) : RuleErrorBuilder {
            if (!$this->treatPhpDocTypesAsCertain) {
                return $ruleErrorBuilder;
            }
            $instanceofTypeWithoutPhpDocs = $scope->doNotTreatPhpDocTypesAsCertain()->getType($node);
            if ($instanceofTypeWithoutPhpDocs instanceof \PHPStan\Type\Constant\ConstantBooleanType) {
                return $ruleErrorBuilder;
            }
            return $ruleErrorBuilder->tip('Because the type is coming from a PHPDoc, you can turn off this check by setting <fg=cyan>treatPhpDocTypesAsCertain: false</> in your <fg=cyan>%configurationFile%</>.');
        };
        if (!$instanceofType->getValue()) {
            return [$addTip(\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Instanceof between %s and %s will always evaluate to false.', $expressionType->describe(\PHPStan\Type\VerbosityLevel::typeOnly()), $classType->describe(\PHPStan\Type\VerbosityLevel::typeOnly()))))->build()];
        } elseif ($this->checkAlwaysTrueInstanceof) {
            return [$addTip(\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Instanceof between %s and %s will always evaluate to true.', $expressionType->describe(\PHPStan\Type\VerbosityLevel::typeOnly()), $classType->describe(\PHPStan\Type\VerbosityLevel::typeOnly()))))->build()];
        }
        return [];
    }
}
