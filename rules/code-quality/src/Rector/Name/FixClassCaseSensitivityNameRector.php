<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodeQuality\Rector\Name;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Param;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\UseUse;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * Mostly mimics source from
 * @see https://github.com/phpstan/phpstan-src/blob/master/src/Rules/ClassCaseSensitivityCheck.php
 *
 * @see \Rector\CodeQuality\Tests\Rector\Name\FixClassCaseSensitivityNameRector\FixClassCaseSensitivityNameRectorTest
 */
final class FixClassCaseSensitivityNameRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change miss-typed case sensitivity name to correct one', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Name::class];
    }
    /**
     * @param Name $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
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
        $parent = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        // do not FQN use imports
        if ($parent instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\UseUse) {
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name($realClassName);
        }
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified($realClassName);
    }
    private function resolveFullyQualifiedName(\_PhpScoper0a2ac50786fa\PhpParser\Node\Name $name) : string
    {
        $parent = $name->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        // for some reason, Param gets already corrected name
        if (!$parent instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Param && !$parent instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch) {
            return $this->getName($name);
        }
        /** @var Name|null $originalName */
        $originalName = $name->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NAME);
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
