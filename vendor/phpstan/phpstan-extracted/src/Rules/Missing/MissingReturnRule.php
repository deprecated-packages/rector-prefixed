<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\Missing;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Node\ExecutionEndNode;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Rule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateMixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\GenericTypeVariableResolver;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\NeverType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel;
use _PhpScoper0a2ac50786fa\PHPStan\Type\VoidType;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\ExecutionEndNode>
 */
class MissingReturnRule implements \_PhpScoper0a2ac50786fa\PHPStan\Rules\Rule
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
        return \_PhpScoper0a2ac50786fa\PHPStan\Node\ExecutionEndNode::class;
    }
    public function processNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : array
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
            $returnType = \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($scopeFunction->getVariants())->getReturnType();
            if ($scopeFunction instanceof \_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection) {
                $description = \sprintf('Method %s::%s()', $scopeFunction->getDeclaringClass()->getDisplayName(), $scopeFunction->getName());
            } else {
                $description = \sprintf('Function %s()', $scopeFunction->getName());
            }
        } else {
            throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
        }
        $isVoidSuperType = $returnType->isSuperTypeOf(new \_PhpScoper0a2ac50786fa\PHPStan\Type\VoidType());
        if ($isVoidSuperType->yes() && !$returnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType) {
            return [];
        }
        if ($statementResult->hasYield()) {
            if ($returnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName && $this->checkPhpDocMissingReturn) {
                $generatorReturnType = \_PhpScoper0a2ac50786fa\PHPStan\Type\GenericTypeVariableResolver::getType($returnType, \Generator::class, 'TReturn');
                if ($generatorReturnType !== null) {
                    $returnType = $generatorReturnType;
                    if ($returnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\VoidType) {
                        return [];
                    }
                    if (!$returnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType) {
                        return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s should return %s but return statement is missing.', $description, $returnType->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::typeOnly())))->line($node->getNode()->getStartLine())->build()];
                    }
                }
            }
            return [];
        }
        if (!$node->hasNativeReturnTypehint() && !$this->checkPhpDocMissingReturn) {
            return [];
        }
        if ($returnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\NeverType && $returnType->isExplicit()) {
            return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s should always throw an exception or terminate script execution but doesn\'t do that.', $description))->line($node->getNode()->getStartLine())->build()];
        }
        if ($returnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType && !$returnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateMixedType && (!$returnType->isExplicitMixed() || !$this->checkExplicitMixedMissingReturn)) {
            return [];
        }
        return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s should return %s but return statement is missing.', $description, $returnType->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::typeOnly())))->line($node->getNode()->getStartLine())->build()];
    }
}
