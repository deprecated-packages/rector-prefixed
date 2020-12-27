<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Cast;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use RectorPrefix20201227\PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\ErrorType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Scalar\Encapsed>
 */
class InvalidPartOfEncapsedStringRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var \PhpParser\PrettyPrinter\Standard */
    private $printer;
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\PhpParser\PrettyPrinter\Standard $printer, \RectorPrefix20201227\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->printer = $printer;
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Scalar\Encapsed::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        $messages = [];
        foreach ($node->parts as $part) {
            if ($part instanceof \PhpParser\Node\Scalar\EncapsedStringPart) {
                continue;
            }
            $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $part, '', static function (\PHPStan\Type\Type $type) : bool {
                return !$type->toString() instanceof \PHPStan\Type\ErrorType;
            });
            $partType = $typeResult->getType();
            if ($partType instanceof \PHPStan\Type\ErrorType) {
                continue;
            }
            $stringPartType = $partType->toString();
            if (!$stringPartType instanceof \PHPStan\Type\ErrorType) {
                continue;
            }
            $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Part %s (%s) of encapsed string cannot be cast to string.', $this->printer->prettyPrintExpr($part), $partType->describe(\PHPStan\Type\VerbosityLevel::value())))->line($part->getLine())->build();
        }
        return $messages;
    }
}
