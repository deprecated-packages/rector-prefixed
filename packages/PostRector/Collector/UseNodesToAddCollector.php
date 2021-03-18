<?php

declare (strict_types=1);
namespace Rector\PostRector\Collector;

use PhpParser\Node;
use PHPStan\Type\ObjectType;
use Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PostRector\Contract\Collector\NodeCollectorInterface;
use Rector\StaticTypeMapper\ValueObject\Type\AliasedObjectType;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
use RectorPrefix20210318\Symplify\SmartFileSystem\SmartFileInfo;
final class UseNodesToAddCollector implements \Rector\PostRector\Contract\Collector\NodeCollectorInterface
{
    /**
     * @var string[][]
     */
    private $removedShortUsesInFilePath = [];
    /**
     * @var FullyQualifiedObjectType[][]
     */
    private $functionUseImportTypesInFilePath = [];
    /**
     * @var CurrentFileInfoProvider
     */
    private $currentFileInfoProvider;
    /**
     * @var FullyQualifiedObjectType[][]|AliasedObjectType[][]
     */
    private $useImportTypesInFilePath = [];
    public function __construct(\Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider $currentFileInfoProvider)
    {
        $this->currentFileInfoProvider = $currentFileInfoProvider;
    }
    public function isActive() : bool
    {
        return $this->useImportTypesInFilePath !== [] || $this->functionUseImportTypesInFilePath !== [];
    }
    /**
     * @param FullyQualifiedObjectType|AliasedObjectType $objectType
     * @param \PhpParser\Node $positionNode
     */
    public function addUseImport($positionNode, $objectType) : void
    {
        /** @var SmartFileInfo|null $fileInfo */
        $fileInfo = $positionNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if (!$fileInfo instanceof \RectorPrefix20210318\Symplify\SmartFileSystem\SmartFileInfo) {
            // fallback for freshly created Name nodes
            $fileInfo = $this->currentFileInfoProvider->getSmartFileInfo();
            if (!$fileInfo instanceof \RectorPrefix20210318\Symplify\SmartFileSystem\SmartFileInfo) {
                return;
            }
        }
        $this->useImportTypesInFilePath[$fileInfo->getRealPath()][] = $objectType;
    }
    /**
     * @param \PhpParser\Node $node
     * @param \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType $fullyQualifiedObjectType
     */
    public function addFunctionUseImport($node, $fullyQualifiedObjectType) : void
    {
        $fileInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if (!$fileInfo instanceof \RectorPrefix20210318\Symplify\SmartFileSystem\SmartFileInfo) {
            return;
        }
        $this->functionUseImportTypesInFilePath[$fileInfo->getRealPath()][] = $fullyQualifiedObjectType;
    }
    /**
     * @param \PhpParser\Node $node
     * @param string $shortUse
     */
    public function removeShortUse($node, $shortUse) : void
    {
        $fileInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if (!$fileInfo instanceof \RectorPrefix20210318\Symplify\SmartFileSystem\SmartFileInfo) {
            return;
        }
        $this->removedShortUsesInFilePath[$fileInfo->getRealPath()][] = $shortUse;
    }
    /**
     * @param \Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo
     */
    public function clear($smartFileInfo) : void
    {
        // clear applied imports, so isActive() doesn't return any false positives
        unset($this->useImportTypesInFilePath[$smartFileInfo->getRealPath()], $this->functionUseImportTypesInFilePath[$smartFileInfo->getRealPath()]);
    }
    /**
     * @return AliasedObjectType[]|FullyQualifiedObjectType[]
     * @param \PhpParser\Node $node
     */
    public function getUseImportTypesByNode($node) : array
    {
        $filePath = $this->getRealPathFromNode($node);
        return $this->useImportTypesInFilePath[$filePath] ?? [];
    }
    /**
     * @param \PhpParser\Node $node
     * @param \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType $fullyQualifiedObjectType
     */
    public function hasImport($node, $fullyQualifiedObjectType) : bool
    {
        $useImports = $this->getUseImportTypesByNode($node);
        foreach ($useImports as $useImport) {
            if ($useImport->equals($fullyQualifiedObjectType)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @param \PhpParser\Node $node
     * @param \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType $fullyQualifiedObjectType
     */
    public function isShortImported($node, $fullyQualifiedObjectType) : bool
    {
        $filePath = $this->getRealPathFromNode($node);
        if ($filePath === null) {
            return \false;
        }
        $shortName = $fullyQualifiedObjectType->getShortName();
        if ($this->isShortClassImported($filePath, $shortName)) {
            return \true;
        }
        $fileFunctionUseImportTypes = $this->functionUseImportTypesInFilePath[$filePath] ?? [];
        foreach ($fileFunctionUseImportTypes as $fileFunctionUseImportType) {
            if ($fileFunctionUseImportType->getShortName() === $fullyQualifiedObjectType->getShortName()) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @param \PhpParser\Node $node
     * @param \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType $fullyQualifiedObjectType
     */
    public function isImportShortable($node, $fullyQualifiedObjectType) : bool
    {
        $filePath = $this->getRealPathFromNode($node);
        $fileUseImportTypes = $this->useImportTypesInFilePath[$filePath] ?? [];
        foreach ($fileUseImportTypes as $fileUseImportType) {
            if ($fullyQualifiedObjectType->equals($fileUseImportType)) {
                return \true;
            }
        }
        $functionImports = $this->functionUseImportTypesInFilePath[$filePath] ?? [];
        foreach ($functionImports as $functionImport) {
            if ($fullyQualifiedObjectType->equals($functionImport)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @return AliasedObjectType[]|FullyQualifiedObjectType[]
     * @param \Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo
     */
    public function getObjectImportsByFileInfo($smartFileInfo) : array
    {
        return $this->useImportTypesInFilePath[$smartFileInfo->getRealPath()] ?? [];
    }
    /**
     * @return FullyQualifiedObjectType[]
     * @param \Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo
     */
    public function getFunctionImportsByFileInfo($smartFileInfo) : array
    {
        return $this->functionUseImportTypesInFilePath[$smartFileInfo->getRealPath()] ?? [];
    }
    /**
     * @return string[]
     * @param \Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo
     */
    public function getShortUsesByFileInfo($smartFileInfo) : array
    {
        return $this->removedShortUsesInFilePath[$smartFileInfo->getRealPath()] ?? [];
    }
    /**
     * @param \PhpParser\Node $node
     */
    private function getRealPathFromNode($node) : ?string
    {
        /** @var SmartFileInfo|null $fileInfo */
        $fileInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if ($fileInfo !== null) {
            return $fileInfo->getRealPath();
        }
        $smartFileInfo = $this->currentFileInfoProvider->getSmartFileInfo();
        if (!$smartFileInfo instanceof \RectorPrefix20210318\Symplify\SmartFileSystem\SmartFileInfo) {
            return null;
        }
        return $smartFileInfo->getRealPath();
    }
    /**
     * @param string $filePath
     * @param string $shortName
     */
    private function isShortClassImported($filePath, $shortName) : bool
    {
        $fileUseImports = $this->useImportTypesInFilePath[$filePath] ?? [];
        foreach ($fileUseImports as $fileUseImport) {
            if ($fileUseImport->getShortName() === $shortName) {
                return \true;
            }
        }
        return \false;
    }
}
