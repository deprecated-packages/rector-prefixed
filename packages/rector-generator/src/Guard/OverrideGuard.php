<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\RectorGenerator\Guard;

use _PhpScopere8e811afab72\Rector\RectorGenerator\FileSystem\TemplateFileSystem;
use _PhpScopere8e811afab72\Rector\RectorGenerator\ValueObject\RectorRecipe;
use _PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(\_PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \_PhpScopere8e811afab72\Rector\RectorGenerator\FileSystem\TemplateFileSystem $templateFileSystem)
    {
        $this->templateFileSystem = $templateFileSystem;
        $this->symfonyStyle = $symfonyStyle;
    }
    /**
     * @param array<string, mixed> $templateVariables
     * @param SmartFileInfo[] $templateFileInfos
     */
    public function isUnwantedOverride(array $templateFileInfos, array $templateVariables, \_PhpScopere8e811afab72\Rector\RectorGenerator\ValueObject\RectorRecipe $rectorRecipe, string $targetDirectory) : bool
    {
        foreach ($templateFileInfos as $templateFileInfo) {
            if (!$this->doesFileInfoAlreadyExist($templateVariables, $rectorRecipe, $templateFileInfo, $targetDirectory)) {
                continue;
            }
            $message = \sprintf('Files for "%s" rule already exist. Should we override them?', $rectorRecipe->getName());
            return !$this->symfonyStyle->confirm($message);
        }
        return \false;
    }
    /**
     * @param array<string, mixed> $templateVariables
     */
    private function doesFileInfoAlreadyExist(array $templateVariables, \_PhpScopere8e811afab72\Rector\RectorGenerator\ValueObject\RectorRecipe $rectorRecipe, \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $templateFileInfo, string $targetDirectory) : bool
    {
        $destination = $this->templateFileSystem->resolveDestination($templateFileInfo, $templateVariables, $rectorRecipe, $targetDirectory);
        return \file_exists($destination);
    }
}
