<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Exceptions;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Rules\Rule;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\TryCatch>
 */
class DeadCatchRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\TryCatch::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        $catchTypes = \array_map(static function (\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Catch_ $catch) : Type {
            return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union(...\array_map(static function (\_PhpScoper0a6b37af0871\PhpParser\Node\Name $className) : ObjectType {
                return new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($className->toString());
            }, $catch->types));
        }, $node->catches);
        $catchesCount = \count($catchTypes);
        $errors = [];
        for ($i = 0; $i < $catchesCount - 1; $i++) {
            $firstType = $catchTypes[$i];
            for ($j = $i + 1; $j < $catchesCount; $j++) {
                $secondType = $catchTypes[$j];
                if (!$firstType->isSuperTypeOf($secondType)->yes()) {
                    continue;
                }
                $errors[] = \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Dead catch - %s is already caught by %s above.', $secondType->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::typeOnly()), $firstType->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::typeOnly())))->line($node->catches[$j]->getLine())->identifier('deadCode.unreachableCatch')->metadata(['tryLine' => $node->getLine(), 'firstCatchOrder' => $i, 'deadCatchOrder' => $j])->build();
            }
        }
        return $errors;
    }
}
