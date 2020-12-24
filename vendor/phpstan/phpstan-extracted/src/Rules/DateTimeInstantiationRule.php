<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules;

use DateTime;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\New_>
 */
class DateTimeInstantiationRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_::class;
    }
    /**
     * @param New_ $node
     */
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->class instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name || \count($node->args) === 0 || !\in_array(\strtolower((string) $node->class), ['datetime', 'datetimeimmutable'], \true)) {
            return [];
        }
        $arg = $scope->getType($node->args[0]->value);
        if (!$arg instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType) {
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
                $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Instantiating %s with %s produces an error: %s', (string) $node->class, $dateString, $error))->build();
            }
        }
        return $errors;
    }
}
