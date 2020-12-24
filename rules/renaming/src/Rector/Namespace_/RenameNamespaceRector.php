<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Namespace_;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\New_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Namespace_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Use_;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\RenamedNamespace;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\NamespaceMatcher;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Renaming\Tests\Rector\Namespace_\RenameNamespaceRector\RenameNamespaceRectorTest
 */
final class RenameNamespaceRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector implements \_PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const OLD_TO_NEW_NAMESPACES = '$oldToNewNamespaces';
    /**
     * @var string[]
     */
    private $oldToNewNamespaces = [];
    /**
     * @var NamespaceMatcher
     */
    private $namespaceMatcher;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\NamespaceMatcher $namespaceMatcher)
    {
        $this->namespaceMatcher = $namespaceMatcher;
    }
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replaces old namespace by new one.', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample('$someObject = new SomeOldNamespace\\SomeClass;', '$someObject = new SomeNewNamespace\\SomeClass;', [self::OLD_TO_NEW_NAMESPACES => ['SomeOldNamespace' => 'SomeNewNamespace']])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Namespace_::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Use_::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name::class];
    }
    /**
     * @param Namespace_|Use_|Name $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        $name = $this->getName($node);
        if ($name === null) {
            return null;
        }
        $renamedNamespaceValueObject = $this->namespaceMatcher->matchRenamedNamespace($name, $this->oldToNewNamespaces);
        if ($renamedNamespaceValueObject === null) {
            return null;
        }
        if ($this->isClassFullyQualifiedName($node)) {
            return null;
        }
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Namespace_) {
            $newName = $renamedNamespaceValueObject->getNameInNewNamespace();
            $node->name = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name($newName);
            return $node;
        }
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Use_) {
            $newName = $renamedNamespaceValueObject->getNameInNewNamespace();
            $node->uses[0]->name = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name($newName);
            return $node;
        }
        $newName = $this->isPartialNamespace($node) ? $this->resolvePartialNewName($node, $renamedNamespaceValueObject) : $renamedNamespaceValueObject->getNameInNewNamespace();
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified($newName);
    }
    /**
     * @param mixed[] $configuration
     */
    public function configure(array $configuration) : void
    {
        $this->oldToNewNamespaces = $configuration[self::OLD_TO_NEW_NAMESPACES] ?? [];
    }
    /**
     * Checks for "new \ClassNoNamespace;"
     * This should be skipped, not a namespace.
     */
    private function isClassFullyQualifiedName(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : bool
    {
        $parentNode = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode === null) {
            return \false;
        }
        if (!$parentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\New_) {
            return \false;
        }
        /** @var FullyQualified $fullyQualifiedNode */
        $fullyQualifiedNode = $parentNode->class;
        $newClassName = $fullyQualifiedNode->toString();
        return \array_key_exists($newClassName, $this->oldToNewNamespaces);
    }
    private function isPartialNamespace(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name $name) : bool
    {
        $resolvedName = $name->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::RESOLVED_NAME);
        if ($resolvedName === null) {
            return \false;
        }
        if ($resolvedName instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified) {
            return !$this->isName($name, $resolvedName->toString());
        }
        return \false;
    }
    private function resolvePartialNewName(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name $name, \_PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\RenamedNamespace $renamedNamespace) : string
    {
        $nameInNewNamespace = $renamedNamespace->getNameInNewNamespace();
        // first dummy implementation - improve
        $cutOffFromTheLeft = \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::length($nameInNewNamespace) - \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::length($name->toString());
        return \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::substring($nameInNewNamespace, $cutOffFromTheLeft);
    }
}
