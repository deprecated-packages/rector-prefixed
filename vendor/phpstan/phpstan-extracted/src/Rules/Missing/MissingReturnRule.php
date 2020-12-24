<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Missing;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Node\ExecutionEndNode;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateMixedType;
use _PhpScopere8e811afab72\PHPStan\Type\GenericTypeVariableResolver;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\NeverType;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
use _PhpScopere8e811afab72\PHPStan\Type\VoidType;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\ExecutionEndNode>
 */
class MissingReturnRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
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
        return \_PhpScopere8e811afab72\PHPStan\Node\ExecutionEndNode::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
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
            $returnType = \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($scopeFunction->getVariants())->getReturnType();
            if ($scopeFunction instanceof \_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection) {
                $description = \sprintf('Method %s::%s()', $scopeFunction->getDeclaringClass()->getDisplayName(), $scopeFunction->getName());
            } else {
                $description = \sprintf('Function %s()', $scopeFunction->getName());
            }
        } else {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        $isVoidSuperType = $returnType->isSuperTypeOf(new \_PhpScopere8e811afab72\PHPStan\Type\VoidType());
        if ($isVoidSuperType->yes() && !$returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return [];
        }
        if ($statementResult->hasYield()) {
            if ($returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName && $this->checkPhpDocMissingReturn) {
                $generatorReturnType = \_PhpScopere8e811afab72\PHPStan\Type\GenericTypeVariableResolver::getType($returnType, \Generator::class, 'TReturn');
                if ($generatorReturnType !== null) {
                    $returnType = $generatorReturnType;
                    if ($returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\VoidType) {
                        return [];
                    }
                    if (!$returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
                        return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s should return %s but return statement is missing.', $description, $returnType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly())))->line($node->getNode()->getStartLine())->build()];
                    }
                }
            }
            return [];
        }
        if (!$node->hasNativeReturnTypehint() && !$this->checkPhpDocMissingReturn) {
            return [];
        }
        if ($returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\NeverType && $returnType->isExplicit()) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s should always throw an exception or terminate script execution but doesn\'t do that.', $description))->line($node->getNode()->getStartLine())->build()];
        }
        if ($returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType && !$returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateMixedType && (!$returnType->isExplicitMixed() || !$this->checkExplicitMixedMissingReturn)) {
            return [];
        }
        return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s should return %s but return statement is missing.', $description, $returnType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly())))->line($node->getNode()->getStartLine())->build()];
    }
}
