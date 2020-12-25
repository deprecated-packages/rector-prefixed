<?php

declare (strict_types=1);
namespace PHPStan\Rules\Exceptions;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\TryCatch>
 */
class DeadCatchRule implements \PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \PhpParser\Node\Stmt\TryCatch::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $catchTypes = \array_map(static function (\PhpParser\Node\Stmt\Catch_ $catch) : Type {
            return \PHPStan\Type\TypeCombinator::union(...\array_map(static function (\PhpParser\Node\Name $className) : ObjectType {
                return new \PHPStan\Type\ObjectType($className->toString());
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
                $errors[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Dead catch - %s is already caught by %s above.', $secondType->describe(\PHPStan\Type\VerbosityLevel::typeOnly()), $firstType->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->line($node->catches[$j]->getLine())->identifier('deadCode.unreachableCatch')->metadata(['tryLine' => $node->getLine(), 'firstCatchOrder' => $i, 'deadCatchOrder' => $j])->build();
            }
        }
        return $errors;
    }
}
