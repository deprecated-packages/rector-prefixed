<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Functions;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Node\InFunctionNode;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Reflection\Php\PhpFunctionFromParserNodeReflection;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeHelper;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\InFunctionNode>
 */
class IncompatibleDefaultParameterTypeRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\Node\InFunctionNode::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $function = $scope->getFunction();
        if (!$function instanceof \_PhpScopere8e811afab72\PHPStan\Reflection\Php\PhpFunctionFromParserNodeReflection) {
            return [];
        }
        $parameters = \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($function->getVariants());
        $errors = [];
        foreach ($node->getOriginalNode()->getParams() as $paramI => $param) {
            if ($param->default === null) {
                continue;
            }
            if ($param->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Error || !\is_string($param->var->name)) {
                throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
            }
            $defaultValueType = $scope->getType($param->default);
            $parameterType = $parameters->getParameters()[$paramI]->getType();
            $parameterType = \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($parameterType);
            if ($parameterType->accepts($defaultValueType, \true)->yes()) {
                continue;
            }
            $verbosityLevel = \_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::getRecommendedLevelByType($parameterType);
            $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Default value of the parameter #%d $%s (%s) of function %s() is incompatible with type %s.', $paramI + 1, $param->var->name, $defaultValueType->describe($verbosityLevel), $function->getName(), $parameterType->describe($verbosityLevel)))->line($param->getLine())->build();
        }
        return $errors;
    }
}
