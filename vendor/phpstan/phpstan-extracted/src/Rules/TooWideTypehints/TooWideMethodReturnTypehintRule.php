<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\TooWideTypehints;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Node\MethodReturnStatementsNode;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector;
use RectorPrefix20201227\PHPStan\Rules\Rule;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\NullType;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\UnionType;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\MethodReturnStatementsNode>
 */
class TooWideMethodReturnTypehintRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var bool */
    private $checkProtectedAndPublicMethods;
    public function __construct(bool $checkProtectedAndPublicMethods)
    {
        $this->checkProtectedAndPublicMethods = $checkProtectedAndPublicMethods;
    }
    public function getNodeType() : string
    {
        return \RectorPrefix20201227\PHPStan\Node\MethodReturnStatementsNode::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        $method = $scope->getFunction();
        if (!$method instanceof \RectorPrefix20201227\PHPStan\Reflection\MethodReflection) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
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
        $methodReturnType = \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($method->getVariants())->getReturnType();
        if (!$methodReturnType instanceof \PHPStan\Type\UnionType) {
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
        $returnType = \PHPStan\Type\TypeCombinator::union(...$returnTypes);
        if (!$method->isPrivate() && ($returnType instanceof \PHPStan\Type\NullType || $returnType instanceof \PHPStan\Type\Constant\ConstantBooleanType) && !$isFirstDeclaration) {
            return [];
        }
        $messages = [];
        foreach ($methodReturnType->getTypes() as $type) {
            if (!$type->isSuperTypeOf($returnType)->no()) {
                continue;
            }
            $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Method %s::%s() never returns %s so it can be removed from the return typehint.', $method->getDeclaringClass()->getDisplayName(), $method->getName(), $type->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
        }
        return $messages;
    }
}
