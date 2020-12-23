<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\Cast;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleLevelHelper;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Cast>
 */
class InvalidCastRule implements \_PhpScoper0a2ac50786fa\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Cast::class;
    }
    public function processNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : array
    {
        $castTypeCallback = static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) use($node) : ?Type {
            if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Cast\Int_) {
                return $type->toInteger();
            } elseif ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Cast\Bool_) {
                return $type->toBoolean();
            } elseif ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Cast\Double) {
                return $type->toFloat();
            } elseif ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Cast\String_) {
                return $type->toString();
            }
            return null;
        };
        $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->expr, '', static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) use($castTypeCallback) : bool {
            $castType = $castTypeCallback($type);
            if ($castType === null) {
                return \true;
            }
            return !$castType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType;
        });
        $type = $typeResult->getType();
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType) {
            return [];
        }
        $castType = $castTypeCallback($type);
        if ($castType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType) {
            $classReflection = $this->reflectionProvider->getClass(\get_class($node));
            $shortName = $classReflection->getNativeReflection()->getShortName();
            $shortName = \strtolower($shortName);
            if ($shortName === 'double') {
                $shortName = 'float';
            } else {
                $shortName = \substr($shortName, 0, -1);
            }
            return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot cast %s to %s.', $scope->getType($node->expr)->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::value()), $shortName))->line($node->getLine())->build()];
        }
        return [];
    }
}
