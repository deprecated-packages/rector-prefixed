<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Cast;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleLevelHelper;
use _PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Scalar\Encapsed>
 */
class InvalidPartOfEncapsedStringRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var \PhpParser\PrettyPrinter\Standard */
    private $printer;
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\PrettyPrinter\Standard $printer, \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->printer = $printer;
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\Encapsed::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        $messages = [];
        foreach ($node->parts as $part) {
            if ($part instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\EncapsedStringPart) {
                continue;
            }
            $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $part, '', static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool {
                return !$type->toString() instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
            });
            $partType = $typeResult->getType();
            if ($partType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
                continue;
            }
            $stringPartType = $partType->toString();
            if (!$stringPartType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
                continue;
            }
            $messages[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Part %s (%s) of encapsed string cannot be cast to string.', $this->printer->prettyPrintExpr($part), $partType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::value())))->line($part->getLine())->build();
        }
        return $messages;
    }
}
