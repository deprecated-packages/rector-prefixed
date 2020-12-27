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
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Echo_>
 */
class EchoRule implements \PHPStan\Rules\Rule
{
    /** @var RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Stmt\Echo_::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $messages = [];
        foreach ($node->exprs as $key => $expr) {
            $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $expr, '', static function (\PHPStan\Type\Type $type) : bool {
                return !$type->toString() instanceof \PHPStan\Type\ErrorType;
            });
            if ($typeResult->getType() instanceof \PHPStan\Type\ErrorType || !$typeResult->getType()->toString() instanceof \PHPStan\Type\ErrorType) {
                continue;
            }
            $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d (%s) of echo cannot be converted to string.', $key + 1, $typeResult->getType()->describe(\PHPStan\Type\VerbosityLevel::value())))->line($expr->getLine())->build();
        }
        return $messages;
    }
}
