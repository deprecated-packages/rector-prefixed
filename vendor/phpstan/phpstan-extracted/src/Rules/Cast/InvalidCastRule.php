<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Cast;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleLevelHelper;
use _PhpScopere8e811afab72\PHPStan\Type\ErrorType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Cast>
 */
class InvalidCastRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScopere8e811afab72\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr\Cast::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $castTypeCallback = static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) use($node) : ?Type {
            if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\Int_) {
                return $type->toInteger();
            } elseif ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\Bool_) {
                return $type->toBoolean();
            } elseif ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\Double) {
                return $type->toFloat();
            } elseif ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\String_) {
                return $type->toString();
            }
            return null;
        };
        $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->expr, '', static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) use($castTypeCallback) : bool {
            $castType = $castTypeCallback($type);
            if ($castType === null) {
                return \true;
            }
            return !$castType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType;
        });
        $type = $typeResult->getType();
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType) {
            return [];
        }
        $castType = $castTypeCallback($type);
        if ($castType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType) {
            $classReflection = $this->reflectionProvider->getClass(\get_class($node));
            $shortName = $classReflection->getNativeReflection()->getShortName();
            $shortName = \strtolower($shortName);
            if ($shortName === 'double') {
                $shortName = 'float';
            } else {
                $shortName = \substr($shortName, 0, -1);
            }
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot cast %s to %s.', $scope->getType($node->expr)->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value()), $shortName))->line($node->getLine())->build()];
        }
        return [];
    }
}
