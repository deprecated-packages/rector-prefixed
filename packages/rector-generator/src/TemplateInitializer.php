<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\RectorGenerator;

use _PhpScoper0a6b37af0871\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\FileSystemGuard;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem;
final class TemplateInitializer
{
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @var FileSystemGuard
     */
    private $fileSystemGuard;
    public function __construct(\_PhpScoper0a6b37af0871\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\FileSystemGuard $fileSystemGuard)
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->smartFileSystem = $smartFileSystem;
        $this->fileSystemGuard = $fileSystemGuard;
    }
    public function initialize(string $templateFilePath, string $rootFileName) : void
    {
        $this->fileSystemGuard->ensureFileExists($templateFilePath, __METHOD__);
        $targetFilePath = \getcwd() . '/' . $rootFileName;
        $doesFileExist = $this->smartFileSystem->exists($targetFilePath);
        if ($doesFileExist) {
            $message = \sprintf('Config file "%s" already exists', $rootFileName);
            $this->symfonyStyle->warning($message);
        } else {
            $this->smartFileSystem->copy($templateFilePath, $targetFilePath);
            $message = \sprintf('"%s" config file was added', $rootFileName);
            $this->symfonyStyle->success($message);
        }
    }
}
