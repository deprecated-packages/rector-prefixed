<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Cast;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleLevelHelper;
use _PhpScopere8e811afab72\PHPStan\Type\ErrorType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Scalar\Encapsed>
 */
class InvalidPartOfEncapsedStringRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var \PhpParser\PrettyPrinter\Standard */
    private $printer;
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScopere8e811afab72\PhpParser\PrettyPrinter\Standard $printer, \_PhpScopere8e811afab72\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->printer = $printer;
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Scalar\Encapsed::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $messages = [];
        foreach ($node->parts as $part) {
            if ($part instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\EncapsedStringPart) {
                continue;
            }
            $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $part, '', static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool {
                return !$type->toString() instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType;
            });
            $partType = $typeResult->getType();
            if ($partType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType) {
                continue;
            }
            $stringPartType = $partType->toString();
            if (!$stringPartType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType) {
                continue;
            }
            $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Part %s (%s) of encapsed string cannot be cast to string.', $this->printer->prettyPrintExpr($part), $partType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value())))->line($part->getLine())->build();
        }
        return $messages;
    }
}
