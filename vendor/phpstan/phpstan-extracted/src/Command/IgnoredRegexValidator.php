<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Command;

use _PhpScoperb75b35f52b74\Hoa\Compiler\Llk\Parser;
use _PhpScoperb75b35f52b74\Hoa\Compiler\Llk\TreeNode;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PHPStan\PhpDoc\TypeStringResolver;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
use function substr;
class IgnoredRegexValidator
{
    /** @var Parser */
    private $parser;
    /** @var \PHPStan\PhpDoc\TypeStringResolver */
    private $typeStringResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Hoa\Compiler\Llk\Parser $parser, \_PhpScoperb75b35f52b74\PHPStan\PhpDoc\TypeStringResolver $typeStringResolver)
    {
        $this->parser = $parser;
        $this->typeStringResolver = $typeStringResolver;
    }
    public function validate(string $regex) : \_PhpScoperb75b35f52b74\PHPStan\Command\IgnoredRegexValidatorResult
    {
        $regex = $this->removeDelimiters($regex);
        try {
            /** @var TreeNode $ast */
            $ast = $this->parser->parse($regex);
        } catch (\_PhpScoperb75b35f52b74\Hoa\Exception\Exception $e) {
            if (\strpos($e->getMessage(), 'Unexpected token "|" (alternation) at line 1') === 0) {
                return new \_PhpScoperb75b35f52b74\PHPStan\Command\IgnoredRegexValidatorResult([], \false, \true, '||', '\\|\\|');
            }
            if (\strpos($regex, '()') !== \false && \strpos($e->getMessage(), 'Unexpected token ")" (_capturing) at line 1') === 0) {
                return new \_PhpScoperb75b35f52b74\PHPStan\Command\IgnoredRegexValidatorResult([], \false, \true, '()', '\\(\\)');
            }
            return new \_PhpScoperb75b35f52b74\PHPStan\Command\IgnoredRegexValidatorResult([], \false, \false);
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Command\IgnoredRegexValidatorResult($this->getIgnoredTypes($ast), $this->hasAnchorsInTheMiddle($ast), \false);
    }
    /**
     * @param TreeNode $ast
     * @return array<string, string>
     */
    private function getIgnoredTypes(\_PhpScoperb75b35f52b74\Hoa\Compiler\Llk\TreeNode $ast) : array
    {
        /** @var TreeNode|null $alternation */
        $alternation = $ast->getChild(0);
        if ($alternation === null) {
            return [];
        }
        if ($alternation->getId() !== '#alternation') {
            return [];
        }
        $types = [];
        foreach ($alternation->getChildren() as $child) {
            $text = $this->getText($child);
            if ($text === null) {
                continue;
            }
            $matches = \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::match($text, '#^([a-zA-Z0-9]+)[,]?\\s*#');
            if ($matches === null) {
                continue;
            }
            try {
                $type = $this->typeStringResolver->resolve($matches[1], null);
            } catch (\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Parser\ParserException $e) {
                continue;
            }
            if ($type->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly()) !== $matches[1]) {
                continue;
            }
            if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
                continue;
            }
            $types[$type->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly())] = $text;
        }
        return $types;
    }
    private function removeDelimiters(string $regex) : string
    {
        $delimiter = \substr($regex, 0, 1);
        $endDelimiterPosition = \strrpos($regex, $delimiter);
        if ($endDelimiterPosition === \false) {
            throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
        }
        return \substr($regex, 1, $endDelimiterPosition - 1);
    }
    private function getText(\_PhpScoperb75b35f52b74\Hoa\Compiler\Llk\TreeNode $treeNode) : ?string
    {
        if ($treeNode->getId() === 'token') {
            return $treeNode->getValueValue();
        }
        if ($treeNode->getId() === '#concatenation') {
            $fullText = '';
            foreach ($treeNode->getChildren() as $child) {
                $text = $this->getText($child);
                if ($text === null) {
                    continue;
                }
                $fullText .= $text;
            }
            if ($fullText === '') {
                return null;
            }
            return $fullText;
        }
        return null;
    }
    private function hasAnchorsInTheMiddle(\_PhpScoperb75b35f52b74\Hoa\Compiler\Llk\TreeNode $ast) : bool
    {
        if ($ast->getId() === 'token') {
            $valueArray = $ast->getValue();
            return $valueArray['token'] === 'anchor' && $valueArray['value'] === '$';
        }
        $childrenCount = \count($ast->getChildren());
        foreach ($ast->getChildren() as $i => $child) {
            $has = $this->hasAnchorsInTheMiddle($child);
            if ($has && ($ast->getId() !== '#concatenation' || $i !== $childrenCount - 1)) {
                return \true;
            }
        }
        return \false;
    }
}
