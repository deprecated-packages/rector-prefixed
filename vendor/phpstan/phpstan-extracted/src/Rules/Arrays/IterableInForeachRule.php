<?php

declare (strict_types=1);
namespace PHPStan\Rules\Arrays;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\ErrorType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Foreach_>
 */
class IterableInForeachRule implements \PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Stmt\Foreach_::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->expr, 'Iterating over an object of an unknown class %s.', static function (\PHPStan\Type\Type $type) : bool {
            return $type->isIterable()->yes();
        });
        $type = $typeResult->getType();
        if ($type instanceof \PHPStan\Type\ErrorType) {
            return $typeResult->getUnknownClassErrors();
        }
        if ($type->isIterable()->yes()) {
            return [];
        }
        return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Argument of an invalid type %s supplied for foreach, only iterables are supported.', $type->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->line($node->expr->getLine())->build()];
    }
}
