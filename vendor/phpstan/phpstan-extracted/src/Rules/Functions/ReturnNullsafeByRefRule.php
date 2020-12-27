<?php

declare (strict_types=1);
namespace PHPStan\Rules\Functions;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\ReturnStatementsNode;
use PHPStan\Rules\NullsafeCheck;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<ReturnStatementsNode>
 */
class ReturnNullsafeByRefRule implements \PHPStan\Rules\Rule
{
    /** @var NullsafeCheck */
    private $nullsafeCheck;
    public function __construct(\PHPStan\Rules\NullsafeCheck $nullsafeCheck)
    {
        $this->nullsafeCheck = $nullsafeCheck;
    }
    public function getNodeType() : string
    {
        return \PHPStan\Node\ReturnStatementsNode::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->returnsByRef()) {
            return [];
        }
        $errors = [];
        foreach ($node->getReturnStatements() as $returnStatement) {
            $returnNode = $returnStatement->getReturnNode();
            if ($returnNode->expr === null) {
                continue;
            }
            if (!$this->nullsafeCheck->containsNullSafe($returnNode->expr)) {
                continue;
            }
            $errors[] = \PHPStan\Rules\RuleErrorBuilder::message('Nullsafe cannot be returned by reference.')->line($returnNode->getLine())->nonIgnorable()->build();
        }
        return $errors;
    }
}
