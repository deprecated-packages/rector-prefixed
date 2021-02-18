<?php

declare (strict_types=1);
namespace Rector\RectorGenerator\Guard;

use Rector\RectorGenerator\FileSystem\TemplateFileSystem;
use Rector\RectorGenerator\ValueObject\RectorRecipe;
use RectorPrefix20210218\Symfony\Component\Console\Style\SymfonyStyle;
use RectorPrefix20210218\Symplify\SmartFileSystem\SmartFileInfo;
final class OverrideGuard
{
    /**
     * @var TemplateFileSystem
     */
    private $templateFileSystem;
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    public function __construct(\RectorPrefix20210218\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \Rector\RectorGenerator\FileSystem\TemplateFileSystem $templateFileSystem)
    {
        $this->templateFileSystem = $templateFileSystem;
        $this->symfonyStyle = $symfonyStyle;
    }
    /**
     * @param array<string, mixed> $templateVariables
     * @param SmartFileInfo[] $templateFileInfos
     */
    public function isUnwantedOverride(array $templateFileInfos, array $templateVariables, \Rector\RectorGenerator\ValueObject\RectorRecipe $rectorRecipe, string $targetDirectory) : bool
    {
        $message = \sprintf('Files for "%s" rule already exist. Should we override them?', $rectorRecipe->getName());
        foreach ($templateFileInfos as $templateFileInfo) {
            if (!$this->doesFileInfoAlreadyExist($templateVariables, $rectorRecipe, $templateFileInfo, $targetDirectory)) {
                continue;
            }
            return !$this->symfonyStyle->confirm($message);
        }
        return \false;
    }
    /**
     * @param array<string, mixed> $templateVariables
     */
    private function doesFileInfoAlreadyExist(array $templateVariables, \Rector\RectorGenerator\ValueObject\RectorRecipe $rectorRecipe, \RectorPrefix20210218\Symplify\SmartFileSystem\SmartFileInfo $templateFileInfo, string $targetDirectory) : bool
    {
        $destination = $this->templateFileSystem->resolveDestination($templateFileInfo, $templateVariables, $rectorRecipe, $targetDirectory);
        return \file_exists($destination);
    }
}
