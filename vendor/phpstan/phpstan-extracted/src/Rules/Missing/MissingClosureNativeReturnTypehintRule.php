<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\Missing;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Node\ClosureReturnStatementsNode;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Rule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a2ac50786fa\PHPStan\Type\IntersectionType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\NeverType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\NullType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ResourceType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeUtils;
use _PhpScoper0a2ac50786fa\PHPStan\Type\UnionType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\ClosureReturnStatementsNode>
 */
class MissingClosureNativeReturnTypehintRule implements \_PhpScoper0a2ac50786fa\PHPStan\Rules\Rule
{
    /** @var bool */
    private $checkObjectTypehint;
    public function __construct(bool $checkObjectTypehint)
    {
        $this->checkObjectTypehint = $checkObjectTypehint;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\Node\ClosureReturnStatementsNode::class;
    }
    public function processNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : array
    {
        $closure = $node->getClosureExpr();
        if ($closure->returnType !== null) {
            return [];
        }
        $messagePattern = 'Anonymous function should have native return typehint "%s".';
        $statementResult = $node->getStatementResult();
        if ($statementResult->hasYield()) {
            return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($messagePattern, 'Generator'))->build()];
        }
        $returnStatements = $node->getReturnStatements();
        if (\count($returnStatements) === 0) {
            return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($messagePattern, 'void'))->build()];
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
            return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($messagePattern, 'void'))->build()];
        }
        $messages = [];
        foreach ($voidReturnNodes as $voidReturnStatement) {
            $messages[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message('Mixing returning values with empty return statements - return null should be used here.')->line($voidReturnStatement->getLine())->build();
        }
        $returnType = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union(...$returnTypes);
        if ($returnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType || $returnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\NeverType || $returnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\IntersectionType || $returnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\NullType) {
            return $messages;
        }
        if (\_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::containsNull($returnType)) {
            $hasNull = \true;
            $returnType = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::removeNull($returnType);
        }
        if ($returnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType || $returnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ResourceType) {
            return $messages;
        }
        if (!$statementResult->isAlwaysTerminating()) {
            $messages[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message('Anonymous function sometimes return something but return statement at the end is missing.')->build();
            return $messages;
        }
        $returnType = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeUtils::generalizeType($returnType);
        $description = $returnType->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::typeOnly());
        if ($returnType->isArray()->yes()) {
            $description = 'array';
        }
        if ($hasNull) {
            $description = '?' . $description;
        }
        if (!$this->checkObjectTypehint && $returnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectWithoutClassType) {
            return $messages;
        }
        $messages[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($messagePattern, $description))->build();
        return $messages;
    }
}
