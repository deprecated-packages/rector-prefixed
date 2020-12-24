<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Functions;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Node\ReturnStatementsNode;
use _PhpScoperb75b35f52b74\PHPStan\Rules\NullsafeCheck;
use _PhpScoperb75b35f52b74\PHPStan\Rules\Rule;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<ReturnStatementsNode>
 */
class ReturnNullsafeByRefRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var NullsafeCheck */
    private $nullsafeCheck;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Rules\NullsafeCheck $nullsafeCheck)
    {
        $this->nullsafeCheck = $nullsafeCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Node\ReturnStatementsNode::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
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
            $errors[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message('Nullsafe cannot be returned by reference.')->line($returnNode->getLine())->nonIgnorable()->build();
        }
        return $errors;
    }
}
