<?php

declare(strict_types=1);

namespace Rector\PostRector\Collector;

use PhpParser\Node;
use PhpParser\Node\Stmt\Use_;
use PHPStan\Type\ObjectType;
use Rector\Core\Provider\CurrentFileProvider;
use Rector\Core\ValueObject\Application\File;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PostRector\Contract\Collector\NodeCollectorInterface;
use Rector\StaticTypeMapper\ValueObject\Type\AliasedObjectType;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
use Symplify\SmartFileSystem\SmartFileInfo;

final class UseNodesToAddCollector implements NodeCollectorInterface
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
     * @var FullyQualifiedObjectType[][]|AliasedObjectType[][]
     */
    private $useImportTypesInFilePath = [];

    /**
     * @var CurrentFileProvider
     */
    private $currentFileProvider;

    public function __construct(CurrentFileProvider $currentFileProvider)
    {
        $this->currentFileProvider = $currentFileProvider;
    }

    public function isActive(): bool
    {
        return $this->useImportTypesInFilePath !== [] || $this->functionUseImportTypesInFilePath !== [];
    }

    /**
     * @param FullyQualifiedObjectType|AliasedObjectType $objectType
     * @return void
     */
    public function addUseImport(Node $positionNode, ObjectType $objectType)
    {
        $file = $this->currentFileProvider->getFile();
        $smartFileInfo = $file->getSmartFileInfo();

        $this->useImportTypesInFilePath[$smartFileInfo->getRealPath()][] = $objectType;
    }

    /**
     * @return void
     */
    public function addFunctionUseImport(Node $node, FullyQualifiedObjectType $fullyQualifiedObjectType)
    {
        $file = $this->currentFileProvider->getFile();
        $smartFileInfo = $file->getSmartFileInfo();

        $this->functionUseImportTypesInFilePath[$smartFileInfo->getRealPath()][] = $fullyQualifiedObjectType;
    }

    /**
     * @return void
     */
    public function removeShortUse(Node $node, string $shortUse)
    {
        $file = $this->currentFileProvider->getFile();
        if (! $file instanceof File) {
            return;
        }

        $smartFileInfo = $file->getSmartFileInfo();

        $this->removedShortUsesInFilePath[$smartFileInfo->getRealPath()][] = $shortUse;
    }

    /**
     * @return void
     */
    public function clear(SmartFileInfo $smartFileInfo)
    {
        // clear applied imports, so isActive() doesn't return any false positives
        unset($this->useImportTypesInFilePath[$smartFileInfo->getRealPath()], $this->functionUseImportTypesInFilePath[$smartFileInfo->getRealPath()]);
    }

    /**
     * @return AliasedObjectType[]|FullyQualifiedObjectType[]
     */
    public function getUseImportTypesByNode(Node $node): array
    {
        $filePath = $this->getRealPathFromNode();

        $objectTypes = $this->useImportTypesInFilePath[$filePath] ?? [];

        /** @var Use_[] $useNodes */
        $useNodes = (array) $node->getAttribute(AttributeKey::USE_NODES);
        foreach ($useNodes as $useNode) {
            foreach ($useNode->uses as $useUse) {
                if ($useUse->alias === null) {
                    $objectTypes[] = new FullyQualifiedObjectType((string) $useUse->name);
                } else {
                    $objectTypes[] = new AliasedObjectType($useUse->alias->toString(), (string) $useUse->name);
                }
            }
        }

        return $objectTypes;
    }

    public function hasImport(Node $node, FullyQualifiedObjectType $fullyQualifiedObjectType): bool
    {
        $useImports = $this->getUseImportTypesByNode($node);

        foreach ($useImports as $useImport) {
            if ($useImport->equals($fullyQualifiedObjectType)) {
                return true;
            }
        }

        return false;
    }

    public function isShortImported(Node $node, FullyQualifiedObjectType $fullyQualifiedObjectType): bool
    {
        $filePath = $this->getRealPathFromNode();
        if ($filePath === null) {
            return false;
        }

        $shortName = $fullyQualifiedObjectType->getShortName();

        if ($this->isShortClassImported($filePath, $shortName)) {
            return true;
        }

        $fileFunctionUseImportTypes = $this->functionUseImportTypesInFilePath[$filePath] ?? [];
        foreach ($fileFunctionUseImportTypes as $fileFunctionUseImportType) {
            if ($fileFunctionUseImportType->getShortName() === $fullyQualifiedObjectType->getShortName()) {
                return true;
            }
        }

        return false;
    }

    public function isImportShortable(Node $node, FullyQualifiedObjectType $fullyQualifiedObjectType): bool
    {
        $filePath = $this->getRealPathFromNode();

        $fileUseImportTypes = $this->useImportTypesInFilePath[$filePath] ?? [];

        foreach ($fileUseImportTypes as $fileUseImportType) {
            if ($fullyQualifiedObjectType->equals($fileUseImportType)) {
                return true;
            }
        }

        $functionImports = $this->functionUseImportTypesInFilePath[$filePath] ?? [];
        foreach ($functionImports as $functionImport) {
            if ($fullyQualifiedObjectType->equals($functionImport)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return AliasedObjectType[]|FullyQualifiedObjectType[]
     */
    public function getObjectImportsByFileInfo(SmartFileInfo $smartFileInfo): array
    {
        return $this->useImportTypesInFilePath[$smartFileInfo->getRealPath()] ?? [];
    }

    /**
     * @return FullyQualifiedObjectType[]
     */
    public function getFunctionImportsByFileInfo(SmartFileInfo $smartFileInfo): array
    {
        return $this->functionUseImportTypesInFilePath[$smartFileInfo->getRealPath()] ?? [];
    }

    /**
     * @return string[]
     */
    public function getShortUsesByFileInfo(SmartFileInfo $smartFileInfo): array
    {
        return $this->removedShortUsesInFilePath[$smartFileInfo->getRealPath()] ?? [];
    }

    /**
     * @return string|null
     */
    private function getRealPathFromNode()
    {
        $file = $this->currentFileProvider->getFile();
        if (! $file instanceof File) {
            return null;
        }

        $smartFileInfo = $file->getSmartFileInfo();

        return $smartFileInfo->getRealPath();
    }

    private function isShortClassImported(string $filePath, string $shortName): bool
    {
        $fileUseImports = $this->useImportTypesInFilePath[$filePath] ?? [];

        foreach ($fileUseImports as $fileUseImport) {
            if ($fileUseImport->getShortName() === $shortName) {
                return true;
            }
        }

        return false;
    }
}
