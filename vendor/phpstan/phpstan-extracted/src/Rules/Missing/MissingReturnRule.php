<?php

declare (strict_types=1);
namespace PHPStan\Rules\Missing;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\ExecutionEndNode;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\Generic\TemplateMixedType;
use PHPStan\Type\GenericTypeVariableResolver;
use PHPStan\Type\MixedType;
use PHPStan\Type\NeverType;
use PHPStan\Type\TypeWithClassName;
use PHPStan\Type\VerbosityLevel;
use PHPStan\Type\VoidType;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\ExecutionEndNode>
 */
class MissingReturnRule implements \PHPStan\Rules\Rule
{
    /** @var bool */
    private $checkExplicitMixedMissingReturn;
    /** @var bool */
    private $checkPhpDocMissingReturn;
    public function __construct(bool $checkExplicitMixedMissingReturn, bool $checkPhpDocMissingReturn)
    {
        $this->checkExplicitMixedMissingReturn = $checkExplicitMixedMissingReturn;
        $this->checkPhpDocMissingReturn = $checkPhpDocMissingReturn;
    }
    public function getNodeType() : string
    {
        return \PHPStan\Node\ExecutionEndNode::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $statementResult = $node->getStatementResult();
        if ($statementResult->isAlwaysTerminating()) {
            return [];
        }
        $anonymousFunctionReturnType = $scope->getAnonymousFunctionReturnType();
        $scopeFunction = $scope->getFunction();
        if ($anonymousFunctionReturnType !== null) {
            $returnType = $anonymousFunctionReturnType;
            $description = 'Anonymous function';
        } elseif ($scopeFunction !== null) {
            $returnType = \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($scopeFunction->getVariants())->getReturnType();
            if ($scopeFunction instanceof \PHPStan\Reflection\MethodReflection) {
                $description = \sprintf('Method %s::%s()', $scopeFunction->getDeclaringClass()->getDisplayName(), $scopeFunction->getName());
            } else {
                $description = \sprintf('Function %s()', $scopeFunction->getName());
            }
        } else {
            throw new \PHPStan\ShouldNotHappenException();
        }
        $isVoidSuperType = $returnType->isSuperTypeOf(new \PHPStan\Type\VoidType());
        if ($isVoidSuperType->yes() && !$returnType instanceof \PHPStan\Type\MixedType) {
            return [];
        }
        if ($statementResult->hasYield()) {
            if ($returnType instanceof \PHPStan\Type\TypeWithClassName && $this->checkPhpDocMissingReturn) {
                $generatorReturnType = \PHPStan\Type\GenericTypeVariableResolver::getType($returnType, \Generator::class, 'TReturn');
                if ($generatorReturnType !== null) {
                    $returnType = $generatorReturnType;
                    if ($returnType instanceof \PHPStan\Type\VoidType) {
                        return [];
                    }
                    if (!$returnType instanceof \PHPStan\Type\MixedType) {
                        return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s should return %s but return statement is missing.', $description, $returnType->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->line($node->getNode()->getStartLine())->build()];
                    }
                }
            }
            return [];
        }
        if (!$node->hasNativeReturnTypehint() && !$this->checkPhpDocMissingReturn) {
            return [];
        }
        if ($returnType instanceof \PHPStan\Type\NeverType && $returnType->isExplicit()) {
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s should always throw an exception or terminate script execution but doesn\'t do that.', $description))->line($node->getNode()->getStartLine())->build()];
        }
        if ($returnType instanceof \PHPStan\Type\MixedType && !$returnType instanceof \PHPStan\Type\Generic\TemplateMixedType && (!$returnType->isExplicitMixed() || !$this->checkExplicitMixedMissingReturn)) {
            return [];
        }
        return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s should return %s but return statement is missing.', $description, $returnType->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->line($node->getNode()->getStartLine())->build()];
    }
}
