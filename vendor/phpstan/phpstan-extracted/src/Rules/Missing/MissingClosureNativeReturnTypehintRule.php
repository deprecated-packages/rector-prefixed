<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Missing;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Node\ClosureReturnStatementsNode;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\IntersectionType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\NeverType;
use _PhpScopere8e811afab72\PHPStan\Type\NullType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType;
use _PhpScopere8e811afab72\PHPStan\Type\ResourceType;
use _PhpScopere8e811afab72\PHPStan\Type\TypeCombinator;
use _PhpScopere8e811afab72\PHPStan\Type\TypeUtils;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\ClosureReturnStatementsNode>
 */
class MissingClosureNativeReturnTypehintRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var bool */
    private $checkObjectTypehint;
    public function __construct(bool $checkObjectTypehint)
    {
        $this->checkObjectTypehint = $checkObjectTypehint;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\Node\ClosureReturnStatementsNode::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $closure = $node->getClosureExpr();
        if ($closure->returnType !== null) {
            return [];
        }
        $messagePattern = 'Anonymous function should have native return typehint "%s".';
        $statementResult = $node->getStatementResult();
        if ($statementResult->hasYield()) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($messagePattern, 'Generator'))->build()];
        }
        $returnStatements = $node->getReturnStatements();
        if (\count($returnStatements) === 0) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($messagePattern, 'void'))->build()];
        }
        $returnTypes = [];
        $voidReturnNodes = [];
        $hasNull = \false;
        foreach ($returnStatements as $returnStatement) {
            $returnNode = $returnStatement->getReturnNode();
            if ($returnNode->expr === null) {
                $voidReturnNodes[] = $returnNode;
                $hasNull = \true;
                continue;
            }
            $returnTypes[] = $returnStatement->getScope()->getType($returnNode->expr);
        }
        if (\count($returnTypes) === 0) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($messagePattern, 'void'))->build()];
        }
        $messages = [];
        foreach ($voidReturnNodes as $voidReturnStatement) {
            $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message('Mixing returning values with empty return statements - return null should be used here.')->line($voidReturnStatement->getLine())->build();
        }
        $returnType = \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(...$returnTypes);
        if ($returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType || $returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\NeverType || $returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType || $returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\NullType) {
            return $messages;
        }
        if (\_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::containsNull($returnType)) {
            $hasNull = \true;
            $returnType = \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::removeNull($returnType);
        }
        if ($returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType || $returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ResourceType) {
            return $messages;
        }
        if (!$statementResult->isAlwaysTerminating()) {
            $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message('Anonymous function sometimes return something but return statement at the end is missing.')->build();
            return $messages;
        }
        $returnType = \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::generalizeType($returnType);
        $description = $returnType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly());
        if ($returnType->isArray()->yes()) {
            $description = 'array';
        }
        if ($hasNull) {
            $description = '?' . $description;
        }
        if (!$this->checkObjectTypehint && $returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType) {
            return $messages;
        }
        $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($messagePattern, $description))->build();
        return $messages;
    }
}
