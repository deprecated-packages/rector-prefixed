<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\RectorGenerator\Command;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\RectorGenerator\Composer\ComposerPackageAutoloadUpdater;
use _PhpScoper0a6b37af0871\Rector\RectorGenerator\Config\ConfigFilesystem;
use _PhpScoper0a6b37af0871\Rector\RectorGenerator\Finder\TemplateFinder;
use _PhpScoper0a6b37af0871\Rector\RectorGenerator\Generator\FileGenerator;
use _PhpScoper0a6b37af0871\Rector\RectorGenerator\Guard\OverrideGuard;
use _PhpScoper0a6b37af0871\Rector\RectorGenerator\Provider\RectorRecipeProvider;
use _PhpScoper0a6b37af0871\Rector\RectorGenerator\TemplateVariablesFactory;
use _PhpScoper0a6b37af0871\Symfony\Component\Console\Command\Command;
use _PhpScoper0a6b37af0871\Symfony\Component\Console\Input\InputInterface;
use _PhpScoper0a6b37af0871\Symfony\Component\Console\Output\OutputInterface;
use _PhpScoper0a6b37af0871\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Console\ShellCode;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class GenerateCommand extends \_PhpScoper0a6b37af0871\Symfony\Component\Console\Command\Command
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\RectorGenerator\Composer\ComposerPackageAutoloadUpdater $composerPackageAutoloadUpdater, \_PhpScoper0a6b37af0871\Rector\RectorGenerator\Config\ConfigFilesystem $configFilesystem, \_PhpScoper0a6b37af0871\Rector\RectorGenerator\Generator\FileGenerator $fileGenerator, \_PhpScoper0a6b37af0871\Rector\RectorGenerator\Guard\OverrideGuard $overrideGuard, \_PhpScoper0a6b37af0871\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \_PhpScoper0a6b37af0871\Rector\RectorGenerator\Finder\TemplateFinder $templateFinder, \_PhpScoper0a6b37af0871\Rector\RectorGenerator\TemplateVariablesFactory $templateVariablesFactory, \_PhpScoper0a6b37af0871\Rector\RectorGenerator\Provider\RectorRecipeProvider $rectorRecipeProvider)
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
    protected function execute(\_PhpScoper0a6b37af0871\Symfony\Component\Console\Input\InputInterface $input, \_PhpScoper0a6b37af0871\Symfony\Component\Console\Output\OutputInterface $output) : int
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
            return \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
        }
        $generatedFilePaths = $this->fileGenerator->generateFiles($templateFileInfos, $templateVariables, $rectorRecipe, $targetDirectory);
        $this->configFilesystem->appendRectorServiceToSet($rectorRecipe, $templateVariables);
        $testCaseDirectoryPath = $this->resolveTestCaseDirectoryPath($generatedFilePaths);
        $this->printSuccess($rectorRecipe->getName(), $generatedFilePaths, $testCaseDirectoryPath);
        return \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
    /**
     * @param string[] $generatedFilePaths
     */
    private function resolveTestCaseDirectoryPath(array $generatedFilePaths) : string
    {
        foreach ($generatedFilePaths as $generatedFilePath) {
            if (!\_PhpScoper0a6b37af0871\Nette\Utils\Strings::endsWith($generatedFilePath, 'Test.php')) {
                continue;
            }
            $generatedFileInfo = new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo($generatedFilePath);
            return \dirname($generatedFileInfo->getRelativeFilePathFromCwd());
        }
        throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
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
            $fileInfo = new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo($generatedFilePath);
            $relativeFilePath = $fileInfo->getRelativeFilePathFromCwd();
            $this->symfonyStyle->writeln(' * ' . $relativeFilePath);
        }
        $message = \sprintf('Make tests green again:%svendor/bin/phpunit %s', \PHP_EOL . \PHP_EOL, $testCaseFilePath);
        $this->symfonyStyle->success($message);
    }
}
