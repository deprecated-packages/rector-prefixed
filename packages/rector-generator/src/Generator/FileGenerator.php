<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\RectorGenerator\Generator;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\Rector\RectorGenerator\FileSystem\TemplateFileSystem;
use _PhpScopere8e811afab72\Rector\RectorGenerator\TemplateFactory;
use _PhpScopere8e811afab72\Rector\RectorGenerator\ValueObject\RectorRecipe;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem;
final class FileGenerator
{
    /**
     * @var string
     * @see https://regex101.com/r/RVbPEX/1
     */
    public const RECTOR_UTILS_REGEX = '#Rector\\\\Utils#';
    /**
     * @var TemplateFileSystem
     */
    private $templateFileSystem;
    /**
     * @var TemplateFactory
     */
    private $templateFactory;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    public function __construct(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \_PhpScopere8e811afab72\Rector\RectorGenerator\TemplateFactory $templateFactory, \_PhpScopere8e811afab72\Rector\RectorGenerator\FileSystem\TemplateFileSystem $templateFileSystem)
    {
        $this->templateFileSystem = $templateFileSystem;
        $this->templateFactory = $templateFactory;
        $this->smartFileSystem = $smartFileSystem;
    }
    /**
     * @param SmartFileInfo[] $templateFileInfos
     * @param string[] $templateVariables
     * @return string[]
     */
    public function generateFiles(array $templateFileInfos, array $templateVariables, \_PhpScopere8e811afab72\Rector\RectorGenerator\ValueObject\RectorRecipe $rectorRecipe, string $destinationDirectory) : array
    {
        $generatedFilePaths = [];
        foreach ($templateFileInfos as $fileInfo) {
            $generatedFilePaths[] = $this->generateFileInfoWithTemplateVariables($fileInfo, $templateVariables, $rectorRecipe, $destinationDirectory);
        }
        return $generatedFilePaths;
    }
    /**
     * @param array<string, mixed> $templateVariables
     */
    private function generateFileInfoWithTemplateVariables(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, array $templateVariables, \_PhpScopere8e811afab72\Rector\RectorGenerator\ValueObject\RectorRecipe $rectorRecipe, string $targetDirectory) : string
    {
        $targetFilePath = $this->templateFileSystem->resolveDestination($smartFileInfo, $templateVariables, $rectorRecipe, $targetDirectory);
        $content = $this->templateFactory->create($smartFileInfo->getContents(), $templateVariables);
        // replace "Rector\Utils\" with "Utils\Rector\" for 3rd party packages
        if (!$rectorRecipe->isRectorRepository()) {
            $content = \_PhpScopere8e811afab72\Nette\Utils\Strings::replace($content, self::RECTOR_UTILS_REGEX, '_PhpScopere8e811afab72\\Utils\\Rector');
        }
        $this->smartFileSystem->dumpFile($targetFilePath, $content);
        return $targetFilePath;
    }
}
