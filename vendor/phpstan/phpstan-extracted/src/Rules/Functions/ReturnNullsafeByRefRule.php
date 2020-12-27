<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Functions;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Node\ReturnStatementsNode;
use RectorPrefix20201227\PHPStan\Rules\NullsafeCheck;
use RectorPrefix20201227\PHPStan\Rules\Rule;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<ReturnStatementsNode>
 */
class ReturnNullsafeByRefRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var NullsafeCheck */
    private $nullsafeCheck;
    public function __construct(\RectorPrefix20201227\PHPStan\Rules\NullsafeCheck $nullsafeCheck)
    {
        $this->nullsafeCheck = $nullsafeCheck;
    }
    public function getNodeType() : string
    {
        return \RectorPrefix20201227\PHPStan\Node\ReturnStatementsNode::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
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
            $errors[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message('Nullsafe cannot be returned by reference.')->line($returnNode->getLine())->nonIgnorable()->build();
        }
        return $errors;
    }
}
