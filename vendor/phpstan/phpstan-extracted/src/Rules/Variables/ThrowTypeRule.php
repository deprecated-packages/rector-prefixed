<?php

declare (strict_types=1);
namespace PHPStan\Rules\Variables;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\ErrorType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Throw_>
 */
class ThrowTypeRule implements \PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Stmt\Throw_::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $throwableType = new \PHPStan\Type\ObjectType(\Throwable::class);
        $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->expr, 'Throwing object of an unknown class %s.', static function (\PHPStan\Type\Type $type) use($throwableType) : bool {
            return $throwableType->isSuperTypeOf($type)->yes();
        });
        $foundType = $typeResult->getType();
        if ($foundType instanceof \PHPStan\Type\ErrorType) {
            return $typeResult->getUnknownClassErrors();
        }
        $isSuperType = $throwableType->isSuperTypeOf($foundType);
        if ($isSuperType->yes()) {
            return [];
        }
        return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Invalid type %s to throw.', $foundType->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
    }
}
