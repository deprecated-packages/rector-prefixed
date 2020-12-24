<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Exceptions;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeCombinator;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\TryCatch>
 */
class DeadCatchRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Stmt\TryCatch::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $catchTypes = \array_map(static function (\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Catch_ $catch) : Type {
            return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(...\array_map(static function (\_PhpScopere8e811afab72\PhpParser\Node\Name $className) : ObjectType {
                return new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($className->toString());
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
                $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Dead catch - %s is already caught by %s above.', $secondType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly()), $firstType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly())))->line($node->catches[$j]->getLine())->identifier('deadCode.unreachableCatch')->metadata(['tryLine' => $node->getLine(), 'firstCatchOrder' => $i, 'deadCatchOrder' => $j])->build();
            }
        }
        return $errors;
    }
}
