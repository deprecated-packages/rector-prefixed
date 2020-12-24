<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Cast;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Rules\Rule;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleLevelHelper;
use _PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Print_>
 */
class PrintRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Print_::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->expr, '', static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool {
            return !$type->toString() instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
        });
        if (!$typeResult->getType() instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType && $typeResult->getType()->toString() instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter %s of print cannot be converted to string.', $typeResult->getType()->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::value())))->line($node->expr->getLine())->build()];
        }
        return [];
    }
}
