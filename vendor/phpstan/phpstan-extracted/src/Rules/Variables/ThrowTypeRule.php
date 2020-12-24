<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Variables;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleLevelHelper;
use _PhpScoper0a6b37af0871\PHPStan\Type\ErrorType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Throw_>
 */
class ThrowTypeRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Throw_::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        $throwableType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType(\Throwable::class);
        $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->expr, 'Throwing object of an unknown class %s.', static function (\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) use($throwableType) : bool {
            return $throwableType->isSuperTypeOf($type)->yes();
        });
        $foundType = $typeResult->getType();
        if ($foundType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType) {
            return $typeResult->getUnknownClassErrors();
        }
        $isSuperType = $throwableType->isSuperTypeOf($foundType);
        if ($isSuperType->yes()) {
            return [];
        }
        return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Invalid type %s to throw.', $foundType->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
    }
}
