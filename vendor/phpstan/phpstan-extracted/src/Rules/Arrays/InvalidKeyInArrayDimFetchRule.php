<?php

declare (strict_types=1);
namespace PHPStan\Rules\Arrays;

use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\MixedType;
use PHPStan\Type\TypeUtils;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\ArrayDimFetch>
 */
class InvalidKeyInArrayDimFetchRule implements \PHPStan\Rules\Rule
{
    /** @var bool */
    private $reportMaybes;
    public function __construct(bool $reportMaybes)
    {
        $this->reportMaybes = $reportMaybes;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\ArrayDimFetch::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if ($node->dim === null) {
            return [];
        }
        $varType = $scope->getType($node->var);
        if (\count(\PHPStan\Type\TypeUtils::getArrays($varType)) === 0) {
            return [];
        }
        $dimensionType = $scope->getType($node->dim);
        $isSuperType = \PHPStan\Rules\Arrays\AllowedArrayKeysTypes::getType()->isSuperTypeOf($dimensionType);
        if ($isSuperType->no()) {
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Invalid array key type %s.', $dimensionType->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
        } elseif ($this->reportMaybes && $isSuperType->maybe() && !$dimensionType instanceof \PHPStan\Type\MixedType) {
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Possibly invalid array key type %s.', $dimensionType->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
        }
        return [];
    }
}
