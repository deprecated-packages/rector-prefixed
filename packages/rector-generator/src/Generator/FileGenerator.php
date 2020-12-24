<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\RectorGenerator\Generator;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\Rector\RectorGenerator\FileSystem\TemplateFileSystem;
use _PhpScoperb75b35f52b74\Rector\RectorGenerator\TemplateFactory;
use _PhpScoperb75b35f52b74\Rector\RectorGenerator\ValueObject\RectorRecipe;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem;
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
    public function __construct(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \_PhpScoperb75b35f52b74\Rector\RectorGenerator\TemplateFactory $templateFactory, \_PhpScoperb75b35f52b74\Rector\RectorGenerator\FileSystem\TemplateFileSystem $templateFileSystem)
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
    public function generateFiles(array $templateFileInfos, array $templateVariables, \_PhpScoperb75b35f52b74\Rector\RectorGenerator\ValueObject\RectorRecipe $rectorRecipe, string $destinationDirectory) : array
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
    private function generateFileInfoWithTemplateVariables(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, array $templateVariables, \_PhpScoperb75b35f52b74\Rector\RectorGenerator\ValueObject\RectorRecipe $rectorRecipe, string $targetDirectory) : string
    {
        $targetFilePath = $this->templateFileSystem->resolveDestination($smartFileInfo, $templateVariables, $rectorRecipe, $targetDirectory);
        $content = $this->templateFactory->create($smartFileInfo->getContents(), $templateVariables);
        // replace "Rector\Utils\" with "Utils\Rector\" for 3rd party packages
        if (!$rectorRecipe->isRectorRepository()) {
            $content = \_PhpScoperb75b35f52b74\Nette\Utils\Strings::replace($content, self::RECTOR_UTILS_REGEX, '_PhpScoperb75b35f52b74\\Utils\\Rector');
        }
        $this->smartFileSystem->dumpFile($targetFilePath, $content);
        return $targetFilePath;
    }
}
