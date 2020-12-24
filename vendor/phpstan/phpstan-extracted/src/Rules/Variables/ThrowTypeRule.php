<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Variables;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleLevelHelper;
use _PhpScopere8e811afab72\PHPStan\Type\ErrorType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Throw_>
 */
class ThrowTypeRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Throw_::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $throwableType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType(\Throwable::class);
        $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->expr, 'Throwing object of an unknown class %s.', static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) use($throwableType) : bool {
            return $throwableType->isSuperTypeOf($type)->yes();
        });
        $foundType = $typeResult->getType();
        if ($foundType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType) {
            return $typeResult->getUnknownClassErrors();
        }
        $isSuperType = $throwableType->isSuperTypeOf($foundType);
        if ($isSuperType->yes()) {
            return [];
        }
        return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Invalid type %s to throw.', $foundType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
    }
}
