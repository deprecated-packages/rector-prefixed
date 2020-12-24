<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Variables;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleLevelHelper;
use _PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Throw_>
 */
class ThrowTypeRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Throw_::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        $throwableType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType(\Throwable::class);
        $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->expr, 'Throwing object of an unknown class %s.', static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) use($throwableType) : bool {
            return $throwableType->isSuperTypeOf($type)->yes();
        });
        $foundType = $typeResult->getType();
        if ($foundType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
            return $typeResult->getUnknownClassErrors();
        }
        $isSuperType = $throwableType->isSuperTypeOf($foundType);
        if ($isSuperType->yes()) {
            return [];
        }
        return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Invalid type %s to throw.', $foundType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
    }
}
