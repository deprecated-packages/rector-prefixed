<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Functions;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Node\InFunctionNode;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector;
use RectorPrefix20201227\PHPStan\Reflection\Php\PhpFunctionFromParserNodeReflection;
use RectorPrefix20201227\PHPStan\Rules\Rule;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\Generic\TemplateTypeHelper;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\InFunctionNode>
 */
class IncompatibleDefaultParameterTypeRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \RectorPrefix20201227\PHPStan\Node\InFunctionNode::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        $function = $scope->getFunction();
        if (!$function instanceof \RectorPrefix20201227\PHPStan\Reflection\Php\PhpFunctionFromParserNodeReflection) {
            return [];
        }
        $parameters = \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($function->getVariants());
        $errors = [];
        foreach ($node->getOriginalNode()->getParams() as $paramI => $param) {
            if ($param->default === null) {
                continue;
            }
            if ($param->var instanceof \PhpParser\Node\Expr\Error || !\is_string($param->var->name)) {
                throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
            }
            $defaultValueType = $scope->getType($param->default);
            $parameterType = $parameters->getParameters()[$paramI]->getType();
            $parameterType = \PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($parameterType);
            if ($parameterType->accepts($defaultValueType, \true)->yes()) {
                continue;
            }
            $verbosityLevel = \PHPStan\Type\VerbosityLevel::getRecommendedLevelByType($parameterType);
            $errors[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Default value of the parameter #%d $%s (%s) of function %s() is incompatible with type %s.', $paramI + 1, $param->var->name, $defaultValueType->describe($verbosityLevel), $function->getName(), $parameterType->describe($verbosityLevel)))->line($param->getLine())->build();
        }
        return $errors;
    }
}
