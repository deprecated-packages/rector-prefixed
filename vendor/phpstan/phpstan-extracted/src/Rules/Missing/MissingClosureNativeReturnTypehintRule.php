<?php

declare (strict_types=1);
namespace PHPStan\Rules\Missing;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\ClosureReturnStatementsNode;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NeverType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\ResourceType;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\TypeUtils;
use PHPStan\Type\UnionType;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\ClosureReturnStatementsNode>
 */
class MissingClosureNativeReturnTypehintRule implements \PHPStan\Rules\Rule
{
    /** @var bool */
    private $checkObjectTypehint;
    public function __construct(bool $checkObjectTypehint)
    {
        $this->checkObjectTypehint = $checkObjectTypehint;
    }
    public function getNodeType() : string
    {
        return \PHPStan\Node\ClosureReturnStatementsNode::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $closure = $node->getClosureExpr();
        if ($closure->returnType !== null) {
            return [];
        }
        $messagePattern = 'Anonymous function should have native return typehint "%s".';
        $statementResult = $node->getStatementResult();
        if ($statementResult->hasYield()) {
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($messagePattern, 'Generator'))->build()];
        }
        $returnStatements = $node->getReturnStatements();
        if (\count($returnStatements) === 0) {
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($messagePattern, 'void'))->build()];
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
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($messagePattern, 'void'))->build()];
        }
        $messages = [];
        foreach ($voidReturnNodes as $voidReturnStatement) {
            $messages[] = \PHPStan\Rules\RuleErrorBuilder::message('Mixing returning values with empty return statements - return null should be used here.')->line($voidReturnStatement->getLine())->build();
        }
        $returnType = \PHPStan\Type\TypeCombinator::union(...$returnTypes);
        if ($returnType instanceof \PHPStan\Type\MixedType || $returnType instanceof \PHPStan\Type\NeverType || $returnType instanceof \PHPStan\Type\IntersectionType || $returnType instanceof \PHPStan\Type\NullType) {
            return $messages;
        }
        if (\PHPStan\Type\TypeCombinator::containsNull($returnType)) {
            $hasNull = \true;
            $returnType = \PHPStan\Type\TypeCombinator::removeNull($returnType);
        }
        if ($returnType instanceof \PHPStan\Type\UnionType || $returnType instanceof \PHPStan\Type\ResourceType) {
            return $messages;
        }
        if (!$statementResult->isAlwaysTerminating()) {
            $messages[] = \PHPStan\Rules\RuleErrorBuilder::message('Anonymous function sometimes return something but return statement at the end is missing.')->build();
            return $messages;
        }
        $returnType = \PHPStan\Type\TypeUtils::generalizeType($returnType);
        $description = $returnType->describe(\PHPStan\Type\VerbosityLevel::typeOnly());
        if ($returnType->isArray()->yes()) {
            $description = 'array';
        }
        if ($hasNull) {
            $description = '?' . $description;
        }
        if (!$this->checkObjectTypehint && $returnType instanceof \PHPStan\Type\ObjectWithoutClassType) {
            return $messages;
        }
        $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf($messagePattern, $description))->build();
        return $messages;
    }
}
