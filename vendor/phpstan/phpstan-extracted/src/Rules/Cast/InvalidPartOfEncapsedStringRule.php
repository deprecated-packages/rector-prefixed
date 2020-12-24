<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Cast;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleLevelHelper;
use _PhpScoper0a6b37af0871\PHPStan\Type\ErrorType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Scalar\Encapsed>
 */
class InvalidPartOfEncapsedStringRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    /** @var \PhpParser\PrettyPrinter\Standard */
    private $printer;
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\PrettyPrinter\Standard $printer, \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->printer = $printer;
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\Encapsed::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        $messages = [];
        foreach ($node->parts as $part) {
            if ($part instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\EncapsedStringPart) {
                continue;
            }
            $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $part, '', static function (\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : bool {
                return !$type->toString() instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType;
            });
            $partType = $typeResult->getType();
            if ($partType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType) {
                continue;
            }
            $stringPartType = $partType->toString();
            if (!$stringPartType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType) {
                continue;
            }
            $messages[] = \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Part %s (%s) of encapsed string cannot be cast to string.', $this->printer->prettyPrintExpr($part), $partType->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::value())))->line($part->getLine())->build();
        }
        return $messages;
    }
}
