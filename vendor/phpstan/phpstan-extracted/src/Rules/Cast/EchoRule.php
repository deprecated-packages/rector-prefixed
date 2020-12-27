<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Cast;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Rules\Rule;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use RectorPrefix20201227\PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\ErrorType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Echo_>
 */
class EchoRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\RectorPrefix20201227\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Stmt\Echo_::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        $messages = [];
        foreach ($node->exprs as $key => $expr) {
            $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $expr, '', static function (\PHPStan\Type\Type $type) : bool {
                return !$type->toString() instanceof \PHPStan\Type\ErrorType;
            });
            if ($typeResult->getType() instanceof \PHPStan\Type\ErrorType || !$typeResult->getType()->toString() instanceof \PHPStan\Type\ErrorType) {
                continue;
            }
            $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d (%s) of echo cannot be converted to string.', $key + 1, $typeResult->getType()->describe(\PHPStan\Type\VerbosityLevel::value())))->line($expr->getLine())->build();
        }
        return $messages;
    }
}
