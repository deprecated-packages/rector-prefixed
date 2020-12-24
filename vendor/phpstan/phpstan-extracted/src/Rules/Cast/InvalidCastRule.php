<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Cast;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleLevelHelper;
use _PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Cast>
 */
class InvalidCastRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        $castTypeCallback = static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) use($node) : ?Type {
            if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Int_) {
                return $type->toInteger();
            } elseif ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Bool_) {
                return $type->toBoolean();
            } elseif ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Double) {
                return $type->toFloat();
            } elseif ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\String_) {
                return $type->toString();
            }
            return null;
        };
        $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->expr, '', static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) use($castTypeCallback) : bool {
            $castType = $castTypeCallback($type);
            if ($castType === null) {
                return \true;
            }
            return !$castType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
        });
        $type = $typeResult->getType();
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
            return [];
        }
        $castType = $castTypeCallback($type);
        if ($castType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
            $classReflection = $this->reflectionProvider->getClass(\get_class($node));
            $shortName = $classReflection->getNativeReflection()->getShortName();
            $shortName = \strtolower($shortName);
            if ($shortName === 'double') {
                $shortName = 'float';
            } else {
                $shortName = \substr($shortName, 0, -1);
            }
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot cast %s to %s.', $scope->getType($node->expr)->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::value()), $shortName))->line($node->getLine())->build()];
        }
        return [];
    }
}
