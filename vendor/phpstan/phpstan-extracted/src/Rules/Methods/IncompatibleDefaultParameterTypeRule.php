<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Methods;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Node\InClassMethodNode;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection;
use _PhpScoperb75b35f52b74\PHPStan\Rules\Rule;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeHelper;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\InClassMethodNode>
 */
class IncompatibleDefaultParameterTypeRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Node\InClassMethodNode::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        $method = $scope->getFunction();
        if (!$method instanceof \_PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection) {
            return [];
        }
        $parameters = \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($method->getVariants());
        $errors = [];
        foreach ($node->getOriginalNode()->getParams() as $paramI => $param) {
            if ($param->default === null) {
                continue;
            }
            if ($param->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Error || !\is_string($param->var->name)) {
                throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
            }
            $defaultValueType = $scope->getType($param->default);
            $parameterType = $parameters->getParameters()[$paramI]->getType();
            $parameterType = \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeHelper::resolveToBounds($parameterType);
            if ($parameterType->accepts($defaultValueType, \true)->yes()) {
                continue;
            }
            $verbosityLevel = \_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::getRecommendedLevelByType($parameterType);
            $errors[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Default value of the parameter #%d $%s (%s) of method %s::%s() is incompatible with type %s.', $paramI + 1, $param->var->name, $defaultValueType->describe($verbosityLevel), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $parameterType->describe($verbosityLevel)))->line($param->getLine())->build();
        }
        return $errors;
    }
}
