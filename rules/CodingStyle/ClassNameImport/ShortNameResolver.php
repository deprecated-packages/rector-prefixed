<?php

declare (strict_types=1);
namespace Rector\CodingStyle\ClassNameImport;

use RectorPrefix20210408\Nette\Utils\Reflection;
use RectorPrefix20210408\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\NodeFinder;
use PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocChildNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PropertyTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\Reflection\ReflectionProvider;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider;
use Rector\NodeTypeResolver\Node\AttributeKey;
use ReflectionClass;
use RectorPrefix20210408\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
use RectorPrefix20210408\Symplify\SmartFileSystem\SmartFileInfo;
final class ShortNameResolver
{
    /**
     * @var string
     * @see https://regex101.com/r/KphLd2/1
     */
    private const BIG_LETTER_START_REGEX = '#^[A-Z]#';
    /**
     * @var string[][]
     */
    private $shortNamesByFilePath = [];
    /**
     * @var SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;
    /**
     * @var CurrentFileInfoProvider
     */
    private $currentFileInfoProvider;
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NodeFinder
     */
    private $nodeFinder;
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    public function __construct(\RectorPrefix20210408\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser, \Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider $currentFileInfoProvider, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \PhpParser\NodeFinder $nodeFinder, \PHPStan\Reflection\ReflectionProvider $reflectionProvider, \Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
        $this->currentFileInfoProvider = $currentFileInfoProvider;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeFinder = $nodeFinder;
        $this->reflectionProvider = $reflectionProvider;
        $this->betterNodeFinder = $betterNodeFinder;
    }
    /**
     * @return array<string, string>
     */
    public function resolveForNode(\PhpParser\Node $node) : array
    {
        $realPath = $this->getNodeRealPath($node);
        if (isset($this->shortNamesByFilePath[$realPath])) {
            return $this->shortNamesByFilePath[$realPath];
        }
        $currentStmts = $this->currentFileInfoProvider->getCurrentStmts();
        $shortNamesToFullyQualifiedNames = $this->resolveForStmts($currentStmts);
        $this->shortNamesByFilePath[$realPath] = $shortNamesToFullyQualifiedNames;
        return $shortNamesToFullyQualifiedNames;
    }
    /**
     * Collects all "class <SomeClass>", "trait <SomeTrait>" and "interface <SomeInterface>"
     * @return string[]
     */
    public function resolveShortClassLikeNamesForNode(\PhpParser\Node $node) : array
    {
        $namespace = $this->betterNodeFinder->findParentType($node, \PhpParser\Node\Stmt\Namespace_::class);
        if (!$namespace instanceof \PhpParser\Node\Stmt\Namespace_) {
            // only handle namespace nodes
            return [];
        }
        /** @var ClassLike[] $classLikes */
        $classLikes = $this->nodeFinder->findInstanceOf($namespace, \PhpParser\Node\Stmt\ClassLike::class);
        $shortClassLikeNames = [];
        foreach ($classLikes as $classLike) {
            $shortClassLikeNames[] = $this->nodeNameResolver->getShortName($classLike);
        }
        return \array_unique($shortClassLikeNames);
    }
    private function getNodeRealPath(\PhpParser\Node $node) : ?string
    {
        /** @var SmartFileInfo|null $fileInfo */
        $fileInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if ($fileInfo !== null) {
            return $fileInfo->getRealPath();
        }
        $smartFileInfo = $this->currentFileInfoProvider->getSmartFileInfo();
        if ($smartFileInfo !== null) {
            return $smartFileInfo->getRealPath();
        }
        return null;
    }
    /**
     * @param Node[] $stmts
     * @return array<string, string>
     */
    private function resolveForStmts(array $stmts) : array
    {
        $shortNamesToFullyQualifiedNames = [];
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($stmts, function (\PhpParser\Node $node) use(&$shortNamesToFullyQualifiedNames) : void {
            // class name is used!
            if ($node instanceof \PhpParser\Node\Stmt\ClassLike && $node->name instanceof \PhpParser\Node\Identifier) {
                $fullyQualifiedName = $this->nodeNameResolver->getName($node);
                if ($fullyQualifiedName === null) {
                    return;
                }
                $shortNamesToFullyQualifiedNames[$node->name->toString()] = $fullyQualifiedName;
                return;
            }
            if (!$node instanceof \PhpParser\Node\Name) {
                return;
            }
            $originalName = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NAME);
            if (!$originalName instanceof \PhpParser\Node\Name) {
                return;
            }
            // already short
            if (\RectorPrefix20210408\Nette\Utils\Strings::contains($originalName->toString(), '\\')) {
                return;
            }
            $fullyQualifiedName = $this->nodeNameResolver->getName($node);
            $shortNamesToFullyQualifiedNames[$originalName->toString()] = $fullyQualifiedName;
        });
        $docBlockShortNamesToFullyQualifiedNames = $this->resolveFromDocBlocks($stmts);
        return \array_merge($shortNamesToFullyQualifiedNames, $docBlockShortNamesToFullyQualifiedNames);
    }
    /**
     * @param Node[] $stmts
     * @return array<string, string>
     */
    private function resolveFromDocBlocks(array $stmts) : array
    {
        $reflectionClass = $this->resolveNativeClassReflection($stmts);
        $shortNamesToFullyQualifiedNames = [];
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($stmts, function (\PhpParser\Node $node) use(&$shortNamesToFullyQualifiedNames, $reflectionClass) : void {
            $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);
            foreach ($phpDocInfo->getPhpDocNode()->children as $phpDocChildNode) {
                /** @var PhpDocChildNode $phpDocChildNode */
                $shortTagName = $this->resolveShortTagNameFromPhpDocChildNode($phpDocChildNode);
                if ($shortTagName === null) {
                    continue;
                }
                if ($reflectionClass !== null) {
                    $fullyQualifiedTagName = \RectorPrefix20210408\Nette\Utils\Reflection::expandClassName($shortTagName, $reflectionClass);
                } else {
                    $fullyQualifiedTagName = $shortTagName;
                }
                $shortNamesToFullyQualifiedNames[$shortTagName] = $fullyQualifiedTagName;
            }
        });
        return $shortNamesToFullyQualifiedNames;
    }
    private function resolveShortTagNameFromPhpDocChildNode(\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocChildNode $phpDocChildNode) : ?string
    {
        if (!$phpDocChildNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode) {
            return null;
        }
        $tagName = \ltrim($phpDocChildNode->name, '@');
        // is annotation class - big letter?
        if (\RectorPrefix20210408\Nette\Utils\Strings::match($tagName, self::BIG_LETTER_START_REGEX)) {
            return $tagName;
        }
        if (!$this->isValueNodeWithType($phpDocChildNode->value)) {
            return null;
        }
        $typeNode = $phpDocChildNode->value->type;
        if (!$typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            return null;
        }
        if (\RectorPrefix20210408\Nette\Utils\Strings::contains($typeNode->name, '\\')) {
            return null;
        }
        return $typeNode->name;
    }
    private function isValueNodeWithType(\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode) : bool
    {
        return $phpDocTagValueNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\PropertyTagValueNode || $phpDocTagValueNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode || $phpDocTagValueNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode || $phpDocTagValueNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode || $phpDocTagValueNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode;
    }
    /**
     * @param Node[] $stmts
     */
    private function resolveNativeClassReflection(array $stmts) : ?\ReflectionClass
    {
        $firstClassLike = $this->nodeFinder->findFirstInstanceOf($stmts, \PhpParser\Node\Stmt\ClassLike::class);
        if (!$firstClassLike instanceof \PhpParser\Node\Stmt\ClassLike) {
            return null;
        }
        $className = $this->nodeNameResolver->getName($firstClassLike);
        if (!$className) {
            return null;
        }
        if (!$this->reflectionProvider->hasClass($className)) {
            return null;
        }
        $classReflection = $this->reflectionProvider->getClass($className);
        return $classReflection->getNativeReflection();
    }
}
