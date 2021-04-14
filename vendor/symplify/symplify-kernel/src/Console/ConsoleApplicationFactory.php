<?php

declare(strict_types=1);

namespace Symplify\SymplifyKernel\Console;

use Symfony\Component\Console\Command\Command;
use Symplify\ComposerJsonManipulator\ComposerJsonFactory;
use Symplify\PackageBuilder\Composer\PackageVersionProvider;
use Symplify\PackageBuilder\Parameter\ParameterProvider;
use Symplify\SmartFileSystem\SmartFileSystem;
use Symplify\SymplifyKernel\Strings\StringsConverter;

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
    public function __construct(
        array $commands,
        ParameterProvider $parameterProvider,
        ComposerJsonFactory $composerJsonFactory,
        SmartFileSystem $smartFileSystem
    ) {
        $this->commands = $commands;
        $this->stringsConverter = new StringsConverter();
        $this->parameterProvider = $parameterProvider;
        $this->composerJsonFactory = $composerJsonFactory;
        $this->smartFileSystem = $smartFileSystem;
    }

    public function create(): AutowiredConsoleApplication
    {
        $autowiredConsoleApplication = new AutowiredConsoleApplication($this->commands);
        $this->decorateApplicationWithNameAndVersion($autowiredConsoleApplication);

        return $autowiredConsoleApplication;
    }

    private function decorateApplicationWithNameAndVersion(
        AutowiredConsoleApplication $autowiredConsoleApplication
    ): void {
        $projectDir = $this->parameterProvider->provideStringParameter('kernel.project_dir');
        $packageComposerJsonFilePath = $projectDir . DIRECTORY_SEPARATOR . 'composer.json';

        if (! $this->smartFileSystem->exists($packageComposerJsonFilePath)) {
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

        $packageVersionProvider = new PackageVersionProvider();
        $version = $packageVersionProvider->provide($packageName);

        $autowiredConsoleApplication->setVersion($version);
    }
}
