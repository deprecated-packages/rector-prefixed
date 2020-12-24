<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Exceptions;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Rules\Rule;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\TryCatch>
 */
class DeadCatchRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\TryCatch::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        $catchTypes = \array_map(static function (\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Catch_ $catch) : Type {
            return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(...\array_map(static function (\_PhpScoperb75b35f52b74\PhpParser\Node\Name $className) : ObjectType {
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($className->toString());
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
                $errors[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Dead catch - %s is already caught by %s above.', $secondType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly()), $firstType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly())))->line($node->catches[$j]->getLine())->identifier('deadCode.unreachableCatch')->metadata(['tryLine' => $node->getLine(), 'firstCatchOrder' => $i, 'deadCatchOrder' => $j])->build();
            }
        }
        return $errors;
    }
}
