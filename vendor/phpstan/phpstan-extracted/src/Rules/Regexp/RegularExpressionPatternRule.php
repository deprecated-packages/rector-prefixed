<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Regexp;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\TypeUtils;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\FuncCall>
 */
class RegularExpressionPatternRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\FuncCall::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        $patterns = $this->extractPatterns($node, $scope);
        $errors = [];
        foreach ($patterns as $pattern) {
            $errorMessage = $this->validatePattern($pattern);
            if ($errorMessage === null) {
                continue;
            }
            $errors[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Regex pattern is invalid: %s', $errorMessage))->build();
        }
        return $errors;
    }
    /**
     * @param FuncCall $functionCall
     * @param Scope $scope
     * @return string[]
     */
    private function extractPatterns(\PhpParser\Node\Expr\FuncCall $functionCall, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$functionCall->name instanceof \PhpParser\Node\Name) {
            return [];
        }
        $functionName = \strtolower((string) $functionCall->name);
        if (!\RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Nette\Utils\Strings::startsWith($functionName, 'preg_')) {
            return [];
        }
        if (!isset($functionCall->args[0])) {
            return [];
        }
        $patternNode = $functionCall->args[0]->value;
        $patternType = $scope->getType($patternNode);
        $patternStrings = [];
        foreach (\PHPStan\Type\TypeUtils::getConstantStrings($patternType) as $constantStringType) {
            if (!\in_array($functionName, ['preg_match', 'preg_match_all', 'preg_split', 'preg_grep', 'preg_replace', 'preg_replace_callback', 'preg_filter'], \true)) {
                continue;
            }
            $patternStrings[] = $constantStringType->getValue();
        }
        foreach (\PHPStan\Type\TypeUtils::getConstantArrays($patternType) as $constantArrayType) {
            if (\in_array($functionName, ['preg_replace', 'preg_replace_callback', 'preg_filter'], \true)) {
                foreach ($constantArrayType->getValueTypes() as $arrayKeyType) {
                    if (!$arrayKeyType instanceof \PHPStan\Type\Constant\ConstantStringType) {
                        continue;
                    }
                    $patternStrings[] = $arrayKeyType->getValue();
                }
            }
            if ($functionName !== 'preg_replace_callback_array') {
                continue;
            }
            foreach ($constantArrayType->getKeyTypes() as $arrayKeyType) {
                if (!$arrayKeyType instanceof \PHPStan\Type\Constant\ConstantStringType) {
                    continue;
                }
                $patternStrings[] = $arrayKeyType->getValue();
            }
        }
        return $patternStrings;
    }
    private function validatePattern(string $pattern) : ?string
    {
        try {
            \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Nette\Utils\Strings::match('', $pattern);
        } catch (\RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Nette\Utils\RegexpException $e) {
            return $e->getMessage();
        }
        return null;
    }
}
