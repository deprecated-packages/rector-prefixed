<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\Cast;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Rule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleLevelHelper;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Print_>
 */
class PrintRule implements \_PhpScoper0a2ac50786fa\PHPStan\Rules\Rule
{
    /** @var RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Print_::class;
    }
    public function processNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : array
    {
        $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->expr, '', static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : bool {
            return !$type->toString() instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType;
        });
        if (!$typeResult->getType() instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType && $typeResult->getType()->toString() instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType) {
            return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter %s of print cannot be converted to string.', $typeResult->getType()->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::value())))->line($node->expr->getLine())->build()];
        }
        return [];
    }
}
