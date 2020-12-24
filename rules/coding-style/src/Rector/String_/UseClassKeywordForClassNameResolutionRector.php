<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\Rector\String_;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\String_\UseClassKeywordForClassNameResolutionRector\UseClassKeywordForClassNameResolutionRectorTest
 */
final class UseClassKeywordForClassNameResolutionRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     * @see https://regex101.com/r/Vv41Qr/1/
     */
    private const CLASS_BEFORE_STATIC_ACCESS_REGEX = '#(?<class_name>[\\\\a-zA-Z0-9_\\x80-\\xff]*)::#';
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Use `class` keyword for class name resolution in string instead of hardcoded string reference', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$value = 'App\SomeClass::someMethod()';
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$value = \App\SomeClass . '::someMethod()';
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_::class];
    }
    /**
     * @param String_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $classNames = $this->getExistingClasses($node);
        if ($classNames === []) {
            return $node;
        }
        $parts = $this->getParts($node, $classNames);
        if ($parts === []) {
            return null;
        }
        $exprsToConcat = $this->createExpressionsToConcat($parts);
        return $this->createConcat($exprsToConcat);
    }
    /**
     * @return string[]
     */
    public function getExistingClasses(\_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_ $string) : array
    {
        /** @var mixed[] $matches */
        $matches = \_PhpScopere8e811afab72\Nette\Utils\Strings::matchAll($string->value, self::CLASS_BEFORE_STATIC_ACCESS_REGEX, \PREG_PATTERN_ORDER);
        if (!isset($matches['class_name'])) {
            return [];
        }
        $classNames = [];
        foreach ($matches['class_name'] as $matchedClassName) {
            if (!\class_exists($matchedClassName)) {
                continue;
            }
            $classNames[] = $matchedClassName;
        }
        return $classNames;
    }
    /**
     * @param string[] $classNames
     * @return mixed[]
     */
    public function getParts(\_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_ $string, array $classNames) : array
    {
        $classNames = \array_map(function (string $className) : string {
            return \preg_quote($className);
        }, $classNames);
        // @see https://regex101.com/r/8nGS0F/1
        $parts = \_PhpScopere8e811afab72\Nette\Utils\Strings::split($string->value, '#(' . \implode('|', $classNames) . ')#');
        return \array_filter($parts, function (string $className) : bool {
            return $className !== '';
        });
    }
    /**
     * @param string[] $parts
     * @return ClassConstFetch[]|String_[]
     */
    private function createExpressionsToConcat(array $parts) : array
    {
        $exprsToConcat = [];
        foreach ($parts as $part) {
            if (\class_exists($part)) {
                $exprsToConcat[] = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified(\ltrim($part, '\\')), 'class');
            } else {
                $exprsToConcat[] = new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_($part);
            }
        }
        return $exprsToConcat;
    }
}
