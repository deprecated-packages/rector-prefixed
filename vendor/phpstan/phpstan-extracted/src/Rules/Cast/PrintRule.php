<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Cast;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleLevelHelper;
use _PhpScopere8e811afab72\PHPStan\Type\ErrorType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Print_>
 */
class PrintRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr\Print_::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->expr, '', static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool {
            return !$type->toString() instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType;
        });
        if (!$typeResult->getType() instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType && $typeResult->getType()->toString() instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter %s of print cannot be converted to string.', $typeResult->getType()->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value())))->line($node->expr->getLine())->build()];
        }
        return [];
    }
}
