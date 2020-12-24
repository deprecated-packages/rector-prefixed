<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\SymplifyKernel\Console;

use _PhpScopere8e811afab72\Jean85\PrettyVersions;
use _PhpScopere8e811afab72\Symfony\Component\Console\Command\Command;
use _PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ComposerJsonFactory;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem;
use _PhpScopere8e811afab72\Symplify\SymplifyKernel\Strings\StringsConverter;
use Throwable;
final class ConsoleApplicationFactory
{
    /**
     * @var Command[]
     */
    private $commands = [];
    /**
     * @var StringsConverter
     */
    private $stringsConverter;
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    /**
     * @var ComposerJsonFactory
     */
    private $composerJsonFactory;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @param Command[] $commands
     */
    public function __construct(array $commands, \_PhpScopere8e811afab72\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \_PhpScopere8e811afab72\Symplify\ComposerJsonManipulator\ComposerJsonFactory $composerJsonFactory, \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
    {
        $this->commands = $commands;
        $this->stringsConverter = new \_PhpScopere8e811afab72\Symplify\SymplifyKernel\Strings\StringsConverter();
        $this->parameterProvider = $parameterProvider;
        $this->composerJsonFactory = $composerJsonFactory;
        $this->smartFileSystem = $smartFileSystem;
    }
    public function create() : \_PhpScopere8e811afab72\Symplify\SymplifyKernel\Console\AutowiredConsoleApplication
    {
        $autowiredConsoleApplication = new \_PhpScopere8e811afab72\Symplify\SymplifyKernel\Console\AutowiredConsoleApplication($this->commands);
        $this->decorateApplicationWithNameAndVersion($autowiredConsoleApplication);
        return $autowiredConsoleApplication;
    }
    private function decorateApplicationWithNameAndVersion(\_PhpScopere8e811afab72\Symplify\SymplifyKernel\Console\AutowiredConsoleApplication $autowiredConsoleApplication) : void
    {
        $projectDir = $this->parameterProvider->provideStringParameter('kernel.project_dir');
        $packageComposerJsonFilePath = $projectDir . \DIRECTORY_SEPARATOR . 'composer.json';
        if (!$this->smartFileSystem->exists($packageComposerJsonFilePath)) {
            return;
        }
        // name
        $composerJson = $this->composerJsonFactory->createFromFilePath($packageComposerJsonFilePath);
        $shortName = $composerJson->getShortName();
        if ($shortName === null) {
            return;
        }
        $projectName = $this->stringsConverter->dashedToCamelCaseWithGlue($shortName, ' ');
        $autowiredConsoleApplication->setName($projectName);
        // version
        $packageName = $composerJson->getName();
        if ($packageName === null) {
            return;
        }
        $packageVersion = $this->resolveVersionFromPackageName($packageName);
        $autowiredConsoleApplication->setVersion($packageVersion);
    }
    private function resolveVersionFromPackageName(string $packageName) : string
    {
        try {
            $version = \_PhpScopere8e811afab72\Jean85\PrettyVersions::getVersion($packageName);
            return $version->getPrettyVersion();
        } catch (\Throwable $throwable) {
            return 'Unknown';
        }
    }
}
