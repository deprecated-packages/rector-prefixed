<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules;

use DateTime;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\New_>
 */
class DateTimeInstantiationRule implements \_PhpScoper0a2ac50786fa\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_::class;
    }
    /**
     * @param New_ $node
     */
    public function processNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->class instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Name || \count($node->args) === 0 || !\in_array(\strtolower((string) $node->class), ['datetime', 'datetimeimmutable'], \true)) {
            return [];
        }
        $arg = $scope->getType($node->args[0]->value);
        if (!$arg instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType) {
            return [];
        }
        $errors = [];
        $dateString = $arg->getValue();
        try {
            new \DateTime($dateString);
        } catch (\Throwable $e) {
            // an exception is thrown for errors only but we want to catch warnings too
        }
        $lastErrors = \DateTime::getLastErrors();
        if ($lastErrors !== \false) {
            foreach ($lastErrors['errors'] as $error) {
                $errors[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Instantiating %s with %s produces an error: %s', (string) $node->class, $dateString, $error))->build();
            }
        }
        return $errors;
    }
}
