<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules;

use DateTime;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\New_>
 */
class DateTimeInstantiationRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_::class;
    }
    /**
     * @param New_ $node
     */
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name || \count($node->args) === 0 || !\in_array(\strtolower((string) $node->class), ['datetime', 'datetimeimmutable'], \true)) {
            return [];
        }
        $arg = $scope->getType($node->args[0]->value);
        if (!$arg instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType) {
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
                $errors[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Instantiating %s with %s produces an error: %s', (string) $node->class, $dateString, $error))->build();
            }
        }
        return $errors;
    }
}
