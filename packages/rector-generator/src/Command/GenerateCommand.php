<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\RectorGenerator\Command;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\RectorGenerator\Composer\ComposerPackageAutoloadUpdater;
use _PhpScopere8e811afab72\Rector\RectorGenerator\Config\ConfigFilesystem;
use _PhpScopere8e811afab72\Rector\RectorGenerator\Finder\TemplateFinder;
use _PhpScopere8e811afab72\Rector\RectorGenerator\Generator\FileGenerator;
use _PhpScopere8e811afab72\Rector\RectorGenerator\Guard\OverrideGuard;
use _PhpScopere8e811afab72\Rector\RectorGenerator\Provider\RectorRecipeProvider;
use _PhpScopere8e811afab72\Rector\RectorGenerator\TemplateVariablesFactory;
use _PhpScopere8e811afab72\Symfony\Component\Console\Command\Command;
use _PhpScopere8e811afab72\Symfony\Component\Console\Input\InputInterface;
use _PhpScopere8e811afab72\Symfony\Component\Console\Output\OutputInterface;
use _PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Console\ShellCode;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class GenerateCommand extends \_PhpScopere8e811afab72\Symfony\Component\Console\Command\Command
{
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    /**
     * @var TemplateVariablesFactory
     */
    private $templateVariablesFactory;
    /**
     * @var ComposerPackageAutoloadUpdater
     */
    private $composerPackageAutoloadUpdater;
    /**
     * @var TemplateFinder
     */
    private $templateFinder;
    /**
     * @var ConfigFilesystem
     */
    private $configFilesystem;
    /**
     * @var OverrideGuard
     */
    private $overrideGuard;
    /**
     * @var FileGenerator
     */
    private $fileGenerator;
    /**
     * @var RectorRecipeProvider
     */
    private $rectorRecipeProvider;
    public function __construct(\_PhpScopere8e811afab72\Rector\RectorGenerator\Composer\ComposerPackageAutoloadUpdater $composerPackageAutoloadUpdater, \_PhpScopere8e811afab72\Rector\RectorGenerator\Config\ConfigFilesystem $configFilesystem, \_PhpScopere8e811afab72\Rector\RectorGenerator\Generator\FileGenerator $fileGenerator, \_PhpScopere8e811afab72\Rector\RectorGenerator\Guard\OverrideGuard $overrideGuard, \_PhpScopere8e811afab72\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \_PhpScopere8e811afab72\Rector\RectorGenerator\Finder\TemplateFinder $templateFinder, \_PhpScopere8e811afab72\Rector\RectorGenerator\TemplateVariablesFactory $templateVariablesFactory, \_PhpScopere8e811afab72\Rector\RectorGenerator\Provider\RectorRecipeProvider $rectorRecipeProvider)
    {
        parent::__construct();
        $this->symfonyStyle = $symfonyStyle;
        $this->templateVariablesFactory = $templateVariablesFactory;
        $this->composerPackageAutoloadUpdater = $composerPackageAutoloadUpdater;
        $this->templateFinder = $templateFinder;
        $this->configFilesystem = $configFilesystem;
        $this->overrideGuard = $overrideGuard;
        $this->fileGenerator = $fileGenerator;
        $this->rectorRecipeProvider = $rectorRecipeProvider;
    }
    protected function configure() : void
    {
        $this->setAliases(['c', 'create', 'g']);
        $this->setDescription('[DEV] Create a new Rector, in a proper location, with new tests');
    }
    protected function execute(\_PhpScopere8e811afab72\Symfony\Component\Console\Input\InputInterface $input, \_PhpScopere8e811afab72\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $rectorRecipe = $this->rectorRecipeProvider->provide();
        $templateVariables = $this->templateVariablesFactory->createFromRectorRecipe($rectorRecipe);
        // setup psr-4 autoload, if not already in
        $this->composerPackageAutoloadUpdater->processComposerAutoload($rectorRecipe);
        $templateFileInfos = $this->templateFinder->find($rectorRecipe);
        $targetDirectory = \getcwd();
        $isUnwantedOverride = $this->overrideGuard->isUnwantedOverride($templateFileInfos, $templateVariables, $rectorRecipe, $targetDirectory);
        if ($isUnwantedOverride) {
            $this->symfonyStyle->warning('No files were changed');
            return \_PhpScopere8e811afab72\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
        }
        $generatedFilePaths = $this->fileGenerator->generateFiles($templateFileInfos, $templateVariables, $rectorRecipe, $targetDirectory);
        $this->configFilesystem->appendRectorServiceToSet($rectorRecipe, $templateVariables);
        $testCaseDirectoryPath = $this->resolveTestCaseDirectoryPath($generatedFilePaths);
        $this->printSuccess($rectorRecipe->getName(), $generatedFilePaths, $testCaseDirectoryPath);
        return \_PhpScopere8e811afab72\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
    /**
     * @param string[] $generatedFilePaths
     */
    private function resolveTestCaseDirectoryPath(array $generatedFilePaths) : string
    {
        foreach ($generatedFilePaths as $generatedFilePath) {
            if (!\_PhpScopere8e811afab72\Nette\Utils\Strings::endsWith($generatedFilePath, 'Test.php')) {
                continue;
            }
            $generatedFileInfo = new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo($generatedFilePath);
            return \dirname($generatedFileInfo->getRelativeFilePathFromCwd());
        }
        throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
    }
    /**
     * @param string[] $generatedFilePaths
     */
    private function printSuccess(string $name, array $generatedFilePaths, string $testCaseFilePath) : void
    {
        $message = \sprintf('New files generated for "%s":', $name);
        $this->symfonyStyle->title($message);
        \sort($generatedFilePaths);
        foreach ($generatedFilePaths as $generatedFilePath) {
            $fileInfo = new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo($generatedFilePath);
            $relativeFilePath = $fileInfo->getRelativeFilePathFromCwd();
            $this->symfonyStyle->writeln(' * ' . $relativeFilePath);
        }
        $message = \sprintf('Make tests green again:%svendor/bin/phpunit %s', \PHP_EOL . \PHP_EOL, $testCaseFilePath);
        $this->symfonyStyle->success($message);
    }
}
