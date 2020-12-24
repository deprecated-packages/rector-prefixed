<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\RectorGenerator\Guard;

use _PhpScoper0a6b37af0871\Rector\RectorGenerator\FileSystem\TemplateFileSystem;
use _PhpScoper0a6b37af0871\Rector\RectorGenerator\ValueObject\RectorRecipe;
use _PhpScoper0a6b37af0871\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(\_PhpScoper0a6b37af0871\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \_PhpScoper0a6b37af0871\Rector\RectorGenerator\FileSystem\TemplateFileSystem $templateFileSystem)
    {
        $this->templateFileSystem = $templateFileSystem;
        $this->symfonyStyle = $symfonyStyle;
    }
    /**
     * @param array<string, mixed> $templateVariables
     * @param SmartFileInfo[] $templateFileInfos
     */
    public function isUnwantedOverride(array $templateFileInfos, array $templateVariables, \_PhpScoper0a6b37af0871\Rector\RectorGenerator\ValueObject\RectorRecipe $rectorRecipe, string $targetDirectory) : bool
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
    private function doesFileInfoAlreadyExist(array $templateVariables, \_PhpScoper0a6b37af0871\Rector\RectorGenerator\ValueObject\RectorRecipe $rectorRecipe, \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $templateFileInfo, string $targetDirectory) : bool
    {
        $destination = $this->templateFileSystem->resolveDestination($templateFileInfo, $templateVariables, $rectorRecipe, $targetDirectory);
        return \file_exists($destination);
    }
}
