<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Variables;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\IssetCheck;
/**
 * @implements \PHPStan\Rules\Rule<Node\Expr\Isset_>
 */
class IssetRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var IssetCheck */
    private $issetCheck;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\IssetCheck $issetCheck)
    {
        $this->issetCheck = $issetCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr\Isset_::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $messages = [];
        foreach ($node->vars as $var) {
            $error = $this->issetCheck->check($var, $scope, 'in isset()');
            if ($error === null) {
                continue;
            }
            $messages[] = $error;
        }
        return $messages;
    }
}
