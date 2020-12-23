<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Renaming\Rector\FileWithoutNamespace;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property;
use _PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\PseudoNamespaceToNamespace;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PhpDoc\PhpDocTypeRenamer;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper0a2ac50786fa\Webmozart\Assert\Assert;
/**
 * @see \Rector\Renaming\Tests\Rector\FileWithoutNamespace\PseudoNamespaceToNamespaceRector\PseudoNamespaceToNamespaceRectorTest
 */
final class PseudoNamespaceToNamespaceRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const NAMESPACE_PREFIXES_WITH_EXCLUDED_CLASSES = 'namespace_prefixed_with_excluded_classes';
    /**
     * @see https://regex101.com/r/chvLgs/1/
     * @var string
     */
    private const SPLIT_BY_UNDERSCORE_REGEX = '#([a-zA-Z])(_)?(_)([a-zA-Z])#';
    /**
     * @var PseudoNamespaceToNamespace[]
     */
    private $pseudoNamespacesToNamespaces = [];
    /**
     * @var PhpDocTypeRenamer
     */
    private $phpDocTypeRenamer;
    /**
     * @var string|null
     */
    private $newNamespace;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PhpDoc\PhpDocTypeRenamer $phpDocTypeRenamer)
    {
        $this->phpDocTypeRenamer = $phpDocTypeRenamer;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replaces defined Pseudo_Namespaces by Namespace\\Ones.', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
/** @var Some_Chicken $someService */
$someService = new Some_Chicken;
$someClassToKeep = new Some_Class_To_Keep;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
/** @var Some\Chicken $someService */
$someService = new Some\Chicken;
$someClassToKeep = new Some_Class_To_Keep;
CODE_SAMPLE
, [self::NAMESPACE_PREFIXES_WITH_EXCLUDED_CLASSES => [new \_PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\PseudoNamespaceToNamespace('Some_', ['Some_Class_To_Keep'])]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        // property, method
        return [\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_::class];
    }
    /**
     * @param Namespace_|FileWithoutNamespace $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $this->newNamespace = null;
        if ($node instanceof \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace) {
            $stmts = $this->refactorStmts((array) $node->stmts);
            $node->stmts = $stmts;
            // add a new namespace?
            if ($this->newNamespace) {
                $namespace = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name($this->newNamespace));
                $namespace->stmts = $stmts;
                return $namespace;
            }
        }
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_) {
            $this->refactorStmts([$node]);
            return $node;
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $namespacePrefixesWithExcludedClasses = $configuration[self::NAMESPACE_PREFIXES_WITH_EXCLUDED_CLASSES] ?? [];
        \_PhpScoper0a2ac50786fa\Webmozart\Assert\Assert::allIsInstanceOf($namespacePrefixesWithExcludedClasses, \_PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\PseudoNamespaceToNamespace::class);
        $this->pseudoNamespacesToNamespaces = $namespacePrefixesWithExcludedClasses;
    }
    /**
     * @param Stmt[] $stmts
     * @return Stmt[]
     */
    private function refactorStmts(array $stmts) : array
    {
        $this->traverseNodesWithCallable($stmts, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?Node {
            if (!$this->isInstancesOf($node, [\_PhpScoper0a2ac50786fa\PhpParser\Node\Name::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike::class])) {
                return null;
            }
            // replace on @var/@param/@return/@throws
            foreach ($this->pseudoNamespacesToNamespaces as $namespacePrefixWithExcludedClasses) {
                $this->phpDocTypeRenamer->changeUnderscoreType($node, $namespacePrefixWithExcludedClasses);
            }
            if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Name || $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier) {
                return $this->processNameOrIdentifier($node);
            }
            return null;
        });
        return $stmts;
    }
    /**
     * @param class-string[] $types
     */
    private function isInstancesOf(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, array $types) : bool
    {
        foreach ($types as $type) {
            if (\is_a($node, $type, \true)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @param Name|Identifier $node
     * @return Name|Identifier
     */
    private function processNameOrIdentifier(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        // no name → skip
        if ($node->toString() === '') {
            return null;
        }
        foreach ($this->pseudoNamespacesToNamespaces as $pseudoNamespacesToNamespace) {
            if (!$this->isName($node, $pseudoNamespacesToNamespace->getNamespacePrefix() . '*')) {
                continue;
            }
            $excludedClasses = $pseudoNamespacesToNamespace->getExcludedClasses();
            if (\is_array($excludedClasses) && $this->isNames($node, $excludedClasses)) {
                return null;
            }
            if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Name) {
                return $this->processName($node);
            }
            return $this->processIdentifier($node);
        }
        return null;
    }
    private function processName(\_PhpScoper0a2ac50786fa\PhpParser\Node\Name $name) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Name
    {
        $nodeName = $this->getName($name);
        if ($nodeName !== null) {
            $name->parts = \explode('_', $nodeName);
        }
        return $name;
    }
    private function processIdentifier(\_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier $identifier) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier
    {
        $parentNode = $identifier->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_) {
            return null;
        }
        $name = $this->getName($identifier);
        if ($name === null) {
            return null;
        }
        /** @var string $namespaceName */
        $namespaceName = \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::before($name, '_', -1);
        /** @var string $lastNewNamePart */
        $lastNewNamePart = \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::after($name, '_', -1);
        $newNamespace = \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::replace($namespaceName, self::SPLIT_BY_UNDERSCORE_REGEX, '$1$2\\\\$4');
        if ($this->newNamespace !== null && $this->newNamespace !== $newNamespace) {
            throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException('There cannot be 2 different namespaces in one file');
        }
        $this->newNamespace = $newNamespace;
        $identifier->name = $lastNewNamePart;
        return $identifier;
    }
}
