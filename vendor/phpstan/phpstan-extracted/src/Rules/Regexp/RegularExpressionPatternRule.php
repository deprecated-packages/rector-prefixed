<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Regexp;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\FuncCall>
 */
class RegularExpressionPatternRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        $patterns = $this->extractPatterns($node, $scope);
        $errors = [];
        foreach ($patterns as $pattern) {
            $errorMessage = $this->validatePattern($pattern);
            if ($errorMessage === null) {
                continue;
            }
            $errors[] = \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Regex pattern is invalid: %s', $errorMessage))->build();
        }
        return $errors;
    }
    /**
     * @param FuncCall $functionCall
     * @param Scope $scope
     * @return string[]
     */
    private function extractPatterns(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$functionCall->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name) {
            return [];
        }
        $functionName = \strtolower((string) $functionCall->name);
        if (!\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::startsWith($functionName, 'preg_')) {
            return [];
        }
        if (!isset($functionCall->args[0])) {
            return [];
        }
        $patternNode = $functionCall->args[0]->value;
        $patternType = $scope->getType($patternNode);
        $patternStrings = [];
        foreach (\_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getConstantStrings($patternType) as $constantStringType) {
            if (!\in_array($functionName, ['preg_match', 'preg_match_all', 'preg_split', 'preg_grep', 'preg_replace', 'preg_replace_callback', 'preg_filter'], \true)) {
                continue;
            }
            $patternStrings[] = $constantStringType->getValue();
        }
        foreach (\_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getConstantArrays($patternType) as $constantArrayType) {
            if (\in_array($functionName, ['preg_replace', 'preg_replace_callback', 'preg_filter'], \true)) {
                foreach ($constantArrayType->getValueTypes() as $arrayKeyType) {
                    if (!$arrayKeyType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType) {
                        continue;
                    }
                    $patternStrings[] = $arrayKeyType->getValue();
                }
            }
            if ($functionName !== 'preg_replace_callback_array') {
                continue;
            }
            foreach ($constantArrayType->getKeyTypes() as $arrayKeyType) {
                if (!$arrayKeyType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType) {
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
            \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::match('', $pattern);
        } catch (\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\Utils\RegexpException $e) {
            return $e->getMessage();
        }
        return null;
    }
}
