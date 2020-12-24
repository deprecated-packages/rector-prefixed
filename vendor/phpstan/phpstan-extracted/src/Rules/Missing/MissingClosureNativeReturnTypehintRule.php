<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Missing;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Node\ClosureReturnStatementsNode;
use _PhpScoperb75b35f52b74\PHPStan\Rules\Rule;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\NeverType;
use _PhpScoperb75b35f52b74\PHPStan\Type\NullType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ResourceType;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\ClosureReturnStatementsNode>
 */
class MissingClosureNativeReturnTypehintRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var bool */
    private $checkObjectTypehint;
    public function __construct(bool $checkObjectTypehint)
    {
        $this->checkObjectTypehint = $checkObjectTypehint;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Node\ClosureReturnStatementsNode::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        $closure = $node->getClosureExpr();
        if ($closure->returnType !== null) {
            return [];
        }
        $messagePattern = 'Anonymous function should have native return typehint "%s".';
        $statementResult = $node->getStatementResult();
        if ($statementResult->hasYield()) {
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($messagePattern, 'Generator'))->build()];
        }
        $returnStatements = $node->getReturnStatements();
        if (\count($returnStatements) === 0) {
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($messagePattern, 'void'))->build()];
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
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($messagePattern, 'void'))->build()];
        }
        $messages = [];
        foreach ($voidReturnNodes as $voidReturnStatement) {
            $messages[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message('Mixing returning values with empty return statements - return null should be used here.')->line($voidReturnStatement->getLine())->build();
        }
        $returnType = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(...$returnTypes);
        if ($returnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType || $returnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\NeverType || $returnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType || $returnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\NullType) {
            return $messages;
        }
        if (\_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::containsNull($returnType)) {
            $hasNull = \true;
            $returnType = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::removeNull($returnType);
        }
        if ($returnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType || $returnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ResourceType) {
            return $messages;
        }
        if (!$statementResult->isAlwaysTerminating()) {
            $messages[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message('Anonymous function sometimes return something but return statement at the end is missing.')->build();
            return $messages;
        }
        $returnType = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::generalizeType($returnType);
        $description = $returnType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly());
        if ($returnType->isArray()->yes()) {
            $description = 'array';
        }
        if ($hasNull) {
            $description = '?' . $description;
        }
        if (!$this->checkObjectTypehint && $returnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType) {
            return $messages;
        }
        $messages[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($messagePattern, $description))->build();
        return $messages;
    }
}
