<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\ClassNameImport;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocChildNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PropertyTagValueNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
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
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    /**
     * @var CurrentFileInfoProvider
     */
    private $currentFileInfoProvider;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider $currentFileInfoProvider)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->currentFileInfoProvider = $currentFileInfoProvider;
    }
    /**
     * @return string[]
     */
    public function resolveForNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : array
    {
        $realPath = $this->getNodeRealPath($node);
        if (isset($this->shortNamesByFilePath[$realPath])) {
            return $this->shortNamesByFilePath[$realPath];
        }
        $currentStmts = $this->currentFileInfoProvider->getCurrentStmts();
        $shortNames = $this->resolveForStmts($currentStmts);
        $this->shortNamesByFilePath[$realPath] = $shortNames;
        return $shortNames;
    }
    /**
     * Collects all "class <SomeClass>", "trait <SomeTrait>" and "interface <SomeInterface>"
     * @return string[]
     */
    public function resolveShortClassLikeNamesForNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : array
    {
        $namespace = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NODE);
        if ($namespace === null) {
            // only handle namespace nodes
            return [];
        }
        $shortClassLikeNames = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($namespace, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use(&$shortClassLikeNames) {
            // ...
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike) {
                return null;
            }
            if ($node->name === null) {
                return null;
            }
            /** @var string $classShortName */
            $classShortName = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_SHORT_NAME);
            $shortClassLikeNames[] = $classShortName;
        });
        return \array_unique($shortClassLikeNames);
    }
    private function getNodeRealPath(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string
    {
        /** @var SmartFileInfo|null $fileInfo */
        $fileInfo = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
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
     * @return string[]
     */
    private function resolveForStmts(array $stmts) : array
    {
        $shortNames = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use(&$shortNames) : void {
            // class name is used!
            if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike && $node->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier) {
                $shortNames[$node->name->toString()] = $node->name->toString();
                return;
            }
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
                return;
            }
            $originalName = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NAME);
            if (!$originalName instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
                return;
            }
            // already short
            if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::contains($originalName->toString(), '\\')) {
                return;
            }
            $shortNames[$originalName->toString()] = $node->toString();
        });
        $docBlockShortNames = $this->resolveFromDocBlocks($stmts);
        return \array_merge($shortNames, $docBlockShortNames);
    }
    /**
     * @param Node[] $stmts
     * @return string[]
     */
    private function resolveFromDocBlocks(array $stmts) : array
    {
        $shortNames = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use(&$shortNames) {
            /** @var PhpDocInfo|null $phpDocInfo */
            $phpDocInfo = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
            if ($phpDocInfo === null) {
                return null;
            }
            foreach ($phpDocInfo->getPhpDocNode()->children as $phpDocChildNode) {
                $shortTagName = $this->resolveShortTagNameFromPhpDocChildNode($phpDocChildNode);
                if ($shortTagName === null) {
                    continue;
                }
                $shortNames[$shortTagName] = $shortTagName;
            }
        });
        return $shortNames;
    }
    private function resolveShortTagNameFromPhpDocChildNode(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocChildNode $phpDocChildNode) : ?string
    {
        if (!$phpDocChildNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode) {
            return null;
        }
        $tagName = \ltrim($phpDocChildNode->name, '@');
        // is annotation class - big letter?
        if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::match($tagName, self::BIG_LETTER_START_REGEX)) {
            return $tagName;
        }
        if (!$this->isValueNodeWithType($phpDocChildNode->value)) {
            return null;
        }
        $typeNode = $phpDocChildNode->value->type;
        if (!$typeNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode) {
            return null;
        }
        if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::contains($typeNode->name, '\\')) {
            return null;
        }
        return $typeNode->name;
    }
    private function isValueNodeWithType(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $phpDocTagValueNode) : bool
    {
        return $phpDocTagValueNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\PropertyTagValueNode || $phpDocTagValueNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode || $phpDocTagValueNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode || $phpDocTagValueNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode || $phpDocTagValueNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode;
    }
}
