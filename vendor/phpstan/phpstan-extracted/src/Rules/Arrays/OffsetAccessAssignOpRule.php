<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Arrays;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleLevelHelper;
use _PhpScoper0a6b37af0871\PHPStan\Type\ErrorType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\AssignOp>
 */
class OffsetAccessAssignOpRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    /** @var RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\AssignOp::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch) {
            return [];
        }
        $arrayDimFetch = $node->var;
        $potentialDimType = null;
        if ($arrayDimFetch->dim !== null) {
            $potentialDimType = $scope->getType($arrayDimFetch->dim);
        }
        $varTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $arrayDimFetch->var, '', static function (\_PhpScoper0a6b37af0871\PHPStan\Type\Type $varType) use($potentialDimType) : bool {
            $arrayDimType = $varType->setOffsetValueType($potentialDimType, new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType());
            return !$arrayDimType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType;
        });
        $varType = $varTypeResult->getType();
        if ($arrayDimFetch->dim !== null) {
            $dimTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $arrayDimFetch->dim, '', static function (\_PhpScoper0a6b37af0871\PHPStan\Type\Type $dimType) use($varType) : bool {
                $arrayDimType = $varType->setOffsetValueType($dimType, new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType());
                return !$arrayDimType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType;
            });
            $dimType = $dimTypeResult->getType();
            if ($varType->hasOffsetValueType($dimType)->no()) {
                return [];
            }
        } else {
            $dimType = $potentialDimType;
        }
        $resultType = $varType->setOffsetValueType($dimType, new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType());
        if (!$resultType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType) {
            return [];
        }
        if ($dimType === null) {
            return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot assign new offset to %s.', $varType->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
        }
        return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot assign offset %s to %s.', $dimType->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::value()), $varType->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
    }
}
