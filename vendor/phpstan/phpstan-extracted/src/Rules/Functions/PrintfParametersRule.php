<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Functions;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\FuncCall>
 */
class PrintfParametersRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name) {
            return [];
        }
        $functionsArgumentPositions = ['printf' => 0, 'sprintf' => 0, 'sscanf' => 1, 'fscanf' => 1];
        $minimumNumberOfArguments = ['printf' => 1, 'sprintf' => 1, 'sscanf' => 3, 'fscanf' => 3];
        $name = \strtolower((string) $node->name);
        if (!isset($functionsArgumentPositions[$name])) {
            return [];
        }
        $formatArgumentPosition = $functionsArgumentPositions[$name];
        $args = $node->args;
        foreach ($args as $arg) {
            if ($arg->unpack) {
                return [];
            }
        }
        $argsCount = \count($args);
        if ($argsCount < $minimumNumberOfArguments[$name]) {
            return [];
            // caught by CallToFunctionParametersRule
        }
        $formatArgType = $scope->getType($args[$formatArgumentPosition]->value);
        $placeHoldersCount = null;
        foreach (\_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getConstantStrings($formatArgType) as $formatString) {
            $format = $formatString->getValue();
            $tempPlaceHoldersCount = $this->getPlaceholdersCount($name, $format);
            if ($placeHoldersCount === null) {
                $placeHoldersCount = $tempPlaceHoldersCount;
            } elseif ($tempPlaceHoldersCount > $placeHoldersCount) {
                $placeHoldersCount = $tempPlaceHoldersCount;
            }
        }
        if ($placeHoldersCount === null) {
            return [];
        }
        $argsCount -= $formatArgumentPosition;
        if ($argsCount !== $placeHoldersCount + 1) {
            return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf(\sprintf('%s, %s.', $placeHoldersCount === 1 ? 'Call to %s contains %d placeholder' : 'Call to %s contains %d placeholders', $argsCount - 1 === 1 ? '%d value given' : '%d values given'), $name, $placeHoldersCount, $argsCount - 1))->build()];
        }
        return [];
    }
    private function getPlaceholdersCount(string $functionName, string $format) : int
    {
        $specifiers = \in_array($functionName, ['sprintf', 'printf'], \true) ? '[bcdeEfFgGosuxX]' : '(?:[cdDeEfinosuxX]|\\[[^\\]]+\\])';
        $pattern = '~(?<before>%*)%(?:(?<position>\\d+)\\$)?[-+]?(?:[ 0]|(?:\'[^%]))?-?\\d*(?:\\.\\d*)?' . $specifiers . '~';
        $matches = \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::matchAll($format, $pattern, \PREG_SET_ORDER);
        if (\count($matches) === 0) {
            return 0;
        }
        $placeholders = \array_filter($matches, static function (array $match) : bool {
            return \strlen($match['before']) % 2 === 0;
        });
        if (\count($placeholders) === 0) {
            return 0;
        }
        $maxPositionedNumber = 0;
        $maxOrdinaryNumber = 0;
        foreach ($placeholders as $placeholder) {
            if (isset($placeholder['position']) && $placeholder['position'] !== '') {
                $maxPositionedNumber = \max((int) $placeholder['position'], $maxPositionedNumber);
            } else {
                $maxOrdinaryNumber++;
            }
        }
        return \max($maxPositionedNumber, $maxOrdinaryNumber);
    }
}
