<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\TooWideTypehints;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Node\MethodReturnStatementsNode;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a6b37af0871\PHPStan\Rules\Rule;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\NullType;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\MethodReturnStatementsNode>
 */
class TooWideMethodReturnTypehintRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    /** @var bool */
    private $checkProtectedAndPublicMethods;
    public function __construct(bool $checkProtectedAndPublicMethods)
    {
        $this->checkProtectedAndPublicMethods = $checkProtectedAndPublicMethods;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PHPStan\Node\MethodReturnStatementsNode::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        $method = $scope->getFunction();
        if (!$method instanceof \_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection) {
            throw new \_PhpScoper0a6b37af0871\PHPStan\ShouldNotHappenException();
        }
        $isFirstDeclaration = $method->getPrototype()->getDeclaringClass() === $method->getDeclaringClass();
        if (!$method->isPrivate()) {
            if (!$this->checkProtectedAndPublicMethods) {
                return [];
            }
            if ($isFirstDeclaration && !$method->getDeclaringClass()->isFinal() && !$method->isFinal()->yes()) {
                return [];
            }
        }
        $methodReturnType = \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($method->getVariants())->getReturnType();
        if (!$methodReturnType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType) {
            return [];
        }
        $statementResult = $node->getStatementResult();
        if ($statementResult->hasYield()) {
            return [];
        }
        $returnStatements = $node->getReturnStatements();
        if (\count($returnStatements) === 0) {
            return [];
        }
        $returnTypes = [];
        foreach ($returnStatements as $returnStatement) {
            $returnNode = $returnStatement->getReturnNode();
            if ($returnNode->expr === null) {
                continue;
            }
            $returnTypes[] = $returnStatement->getScope()->getType($returnNode->expr);
        }
        if (\count($returnTypes) === 0) {
            return [];
        }
        $returnType = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union(...$returnTypes);
        if (!$method->isPrivate() && ($returnType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\NullType || $returnType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType) && !$isFirstDeclaration) {
            return [];
        }
        $messages = [];
        foreach ($methodReturnType->getTypes() as $type) {
            if (!$type->isSuperTypeOf($returnType)->no()) {
                continue;
            }
            $messages[] = \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Method %s::%s() never returns %s so it can be removed from the return typehint.', $method->getDeclaringClass()->getDisplayName(), $method->getName(), $type->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
        }
        return $messages;
    }
}
