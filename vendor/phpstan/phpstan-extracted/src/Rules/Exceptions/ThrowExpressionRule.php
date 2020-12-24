<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Exceptions;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Php\PhpVersion;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<Node\Expr\Throw_>
 */
class ThrowExpressionRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var PhpVersion */
    private $phpVersion;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Php\PhpVersion $phpVersion)
    {
        $this->phpVersion = $phpVersion;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr\Throw_::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if ($this->phpVersion->supportsThrowExpression()) {
            return [];
        }
        return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message('Throw expression is supported only on PHP 8.0 and later.')->nonIgnorable()->build()];
    }
}
