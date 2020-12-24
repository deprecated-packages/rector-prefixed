<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Functions;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Rules\NullsafeCheck;
use _PhpScoperb75b35f52b74\PHPStan\Rules\Rule;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<Node\Expr\ArrowFunction>
 */
class ArrowFunctionReturnNullsafeByRefRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var NullsafeCheck */
    private $nullsafeCheck;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Rules\NullsafeCheck $nullsafeCheck)
    {
        $this->nullsafeCheck = $nullsafeCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrowFunction::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->byRef) {
            return [];
        }
        if (!$this->nullsafeCheck->containsNullSafe($node->expr)) {
            return [];
        }
        return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message('Nullsafe cannot be returned by reference.')->nonIgnorable()->build()];
    }
}
