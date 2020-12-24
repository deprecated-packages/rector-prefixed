<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Arrays;

use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\ArrayItem>
 */
class InvalidKeyInArrayItemRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var bool */
    private $reportMaybes;
    public function __construct(bool $reportMaybes)
    {
        $this->reportMaybes = $reportMaybes;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node->key === null) {
            return [];
        }
        $dimensionType = $scope->getType($node->key);
        $isSuperType = \_PhpScopere8e811afab72\PHPStan\Rules\Arrays\AllowedArrayKeysTypes::getType()->isSuperTypeOf($dimensionType);
        if ($isSuperType->no()) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Invalid array key type %s.', $dimensionType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
        } elseif ($this->reportMaybes && $isSuperType->maybe() && !$dimensionType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Possibly invalid array key type %s.', $dimensionType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
        }
        return [];
    }
}
