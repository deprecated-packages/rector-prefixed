<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Cast;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use RectorPrefix20201227\PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\ErrorType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Cast>
 */
class InvalidCastRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \RectorPrefix20201227\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\Cast::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        $castTypeCallback = static function (\PHPStan\Type\Type $type) use($node) : ?Type {
            if ($node instanceof \PhpParser\Node\Expr\Cast\Int_) {
                return $type->toInteger();
            } elseif ($node instanceof \PhpParser\Node\Expr\Cast\Bool_) {
                return $type->toBoolean();
            } elseif ($node instanceof \PhpParser\Node\Expr\Cast\Double) {
                return $type->toFloat();
            } elseif ($node instanceof \PhpParser\Node\Expr\Cast\String_) {
                return $type->toString();
            }
            return null;
        };
        $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->expr, '', static function (\PHPStan\Type\Type $type) use($castTypeCallback) : bool {
            $castType = $castTypeCallback($type);
            if ($castType === null) {
                return \true;
            }
            return !$castType instanceof \PHPStan\Type\ErrorType;
        });
        $type = $typeResult->getType();
        if ($type instanceof \PHPStan\Type\ErrorType) {
            return [];
        }
        $castType = $castTypeCallback($type);
        if ($castType instanceof \PHPStan\Type\ErrorType) {
            $classReflection = $this->reflectionProvider->getClass(\get_class($node));
            $shortName = $classReflection->getNativeReflection()->getShortName();
            $shortName = \strtolower($shortName);
            if ($shortName === 'double') {
                $shortName = 'float';
            } else {
                $shortName = \substr($shortName, 0, -1);
            }
            return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot cast %s to %s.', $scope->getType($node->expr)->describe(\PHPStan\Type\VerbosityLevel::value()), $shortName))->line($node->getLine())->build()];
        }
        return [];
    }
}
