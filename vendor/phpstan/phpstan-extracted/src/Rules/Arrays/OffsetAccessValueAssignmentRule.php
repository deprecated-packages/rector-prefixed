<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Arrays;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\AssignOp;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleLevelHelper;
use _PhpScoper0a6b37af0871\PHPStan\Type\ErrorType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<Expr>
 */
class OffsetAccessValueAssignmentRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    /** @var RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Expr::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign && !$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\AssignOp && !$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\AssignRef) {
            return [];
        }
        if (!$node->var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch) {
            return [];
        }
        $arrayDimFetch = $node->var;
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign || $node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\AssignRef) {
            $assignedValueType = $scope->getType($node->expr);
        } else {
            $assignedValueType = $scope->getType($node);
        }
        $originalArrayType = $scope->getType($arrayDimFetch->var);
        $arrayTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $arrayDimFetch->var, '', static function (\_PhpScoper0a6b37af0871\PHPStan\Type\Type $varType) use($assignedValueType) : bool {
            $result = $varType->setOffsetValueType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), $assignedValueType);
            return !$result instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType;
        });
        $arrayType = $arrayTypeResult->getType();
        if ($arrayType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType) {
            return [];
        }
        $isOffsetAccessible = $arrayType->isOffsetAccessible();
        if (!$isOffsetAccessible->yes()) {
            return [];
        }
        $resultType = $arrayType->setOffsetValueType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), $assignedValueType);
        if (!$resultType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType) {
            return [];
        }
        return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s does not accept %s.', $originalArrayType->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::value()), $assignedValueType->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
    }
}
