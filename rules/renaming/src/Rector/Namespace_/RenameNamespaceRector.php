<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Renaming\Rector\Namespace_;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Use_;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\RenamedNamespace;
use _PhpScoper0a6b37af0871\Rector\Naming\NamespaceMatcher;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Renaming\Tests\Rector\Namespace_\RenameNamespaceRector\RenameNamespaceRectorTest
 */
final class RenameNamespaceRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Naming\NamespaceMatcher $namespaceMatcher)
    {
        $this->namespaceMatcher = $namespaceMatcher;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replaces old namespace by new one.', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample('$someObject = new SomeOldNamespace\\SomeClass;', '$someObject = new SomeNewNamespace\\SomeClass;', [self::OLD_TO_NEW_NAMESPACES => ['SomeOldNamespace' => 'SomeNewNamespace']])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Use_::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Name::class];
    }
    /**
     * @param Namespace_|Use_|Name $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
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
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_) {
            $newName = $renamedNamespaceValueObject->getNameInNewNamespace();
            $node->name = new \_PhpScoper0a6b37af0871\PhpParser\Node\Name($newName);
            return $node;
        }
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Use_) {
            $newName = $renamedNamespaceValueObject->getNameInNewNamespace();
            $node->uses[0]->name = new \_PhpScoper0a6b37af0871\PhpParser\Node\Name($newName);
            return $node;
        }
        $newName = $this->isPartialNamespace($node) ? $this->resolvePartialNewName($node, $renamedNamespaceValueObject) : $renamedNamespaceValueObject->getNameInNewNamespace();
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified($newName);
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
    private function isClassFullyQualifiedName(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        $parentNode = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode === null) {
            return \false;
        }
        if (!$parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_) {
            return \false;
        }
        /** @var FullyQualified $fullyQualifiedNode */
        $fullyQualifiedNode = $parentNode->class;
        $newClassName = $fullyQualifiedNode->toString();
        return \array_key_exists($newClassName, $this->oldToNewNamespaces);
    }
    private function isPartialNamespace(\_PhpScoper0a6b37af0871\PhpParser\Node\Name $name) : bool
    {
        $resolvedName = $name->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::RESOLVED_NAME);
        if ($resolvedName === null) {
            return \false;
        }
        if ($resolvedName instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified) {
            return !$this->isName($name, $resolvedName->toString());
        }
        return \false;
    }
    private function resolvePartialNewName(\_PhpScoper0a6b37af0871\PhpParser\Node\Name $name, \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\RenamedNamespace $renamedNamespace) : string
    {
        $nameInNewNamespace = $renamedNamespace->getNameInNewNamespace();
        // first dummy implementation - improve
        $cutOffFromTheLeft = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::length($nameInNewNamespace) - \_PhpScoper0a6b37af0871\Nette\Utils\Strings::length($name->toString());
        return \_PhpScoper0a6b37af0871\Nette\Utils\Strings::substring($nameInNewNamespace, $cutOffFromTheLeft);
    }
}
