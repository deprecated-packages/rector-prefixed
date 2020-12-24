<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Cast;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Rules\Rule;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleLevelHelper;
use _PhpScoper0a6b37af0871\PHPStan\Type\ErrorType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Echo_>
 */
class EchoRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    /** @var RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Echo_::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        $messages = [];
        foreach ($node->exprs as $key => $expr) {
            $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $expr, '', static function (\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : bool {
                return !$type->toString() instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType;
            });
            if ($typeResult->getType() instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType || !$typeResult->getType()->toString() instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType) {
                continue;
            }
            $messages[] = \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d (%s) of echo cannot be converted to string.', $key + 1, $typeResult->getType()->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::value())))->line($expr->getLine())->build();
        }
        return $messages;
    }
}
