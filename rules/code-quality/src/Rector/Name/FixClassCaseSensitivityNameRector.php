<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodeQuality\Rector\Name;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\UseUse;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * Mostly mimics source from
 * @see https://github.com/phpstan/phpstan-src/blob/master/src/Rules/ClassCaseSensitivityCheck.php
 *
 * @see \Rector\CodeQuality\Tests\Rector\Name\FixClassCaseSensitivityNameRector\FixClassCaseSensitivityNameRectorTest
 */
final class FixClassCaseSensitivityNameRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change miss-typed case sensitivity name to correct one', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function run()
    {
        $anotherClass = new anotherclass;
    }
}

final class AnotherClass
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run()
    {
        $anotherClass = new AnotherClass;
    }
}

final class AnotherClass
{
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Name::class];
    }
    /**
     * @param Name $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $fullyQualifiedName = $this->resolveFullyQualifiedName($node);
        if (!$this->reflectionProvider->hasClass($fullyQualifiedName)) {
            return null;
        }
        $classReflection = $this->reflectionProvider->getClass($fullyQualifiedName);
        if ($classReflection->isBuiltin()) {
            // skip built-in classes
            return null;
        }
        $realClassName = $classReflection->getName();
        if (\strtolower($realClassName) !== \strtolower($fullyQualifiedName)) {
            // skip class alias
            return null;
        }
        if ($realClassName === $fullyQualifiedName) {
            return null;
        }
        $parent = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        // do not FQN use imports
        if ($parent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\UseUse) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($realClassName);
        }
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified($realClassName);
    }
    private function resolveFullyQualifiedName(\_PhpScoperb75b35f52b74\PhpParser\Node\Name $name) : string
    {
        $parent = $name->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        // for some reason, Param gets already corrected name
        if (!$parent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Param && !$parent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch) {
            return $this->getName($name);
        }
        /** @var Name|null $originalName */
        $originalName = $name->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NAME);
        if ($originalName === null) {
            return $this->getName($name);
        }
        // replace parts from the old one
        $originalReversedParts = \array_reverse($originalName->parts);
        $resolvedReversedParts = \array_reverse($name->parts);
        $mergedReversedParts = $originalReversedParts + $resolvedReversedParts;
        $mergedParts = \array_reverse($mergedReversedParts);
        return \implode('\\', $mergedParts);
    }
}
