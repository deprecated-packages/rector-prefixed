<?php

declare (strict_types=1);
namespace PHPStan\Rules\Cast;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\ErrorType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Print_>
 */
class PrintRule implements \PHPStan\Rules\Rule
{
    /** @var RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\Print_::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->expr, '', static function (\PHPStan\Type\Type $type) : bool {
            return !$type->toString() instanceof \PHPStan\Type\ErrorType;
        });
        if (!$typeResult->getType() instanceof \PHPStan\Type\ErrorType && $typeResult->getType()->toString() instanceof \PHPStan\Type\ErrorType) {
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter %s of print cannot be converted to string.', $typeResult->getType()->describe(\PHPStan\Type\VerbosityLevel::value())))->line($node->expr->getLine())->build()];
        }
        return [];
    }
}
