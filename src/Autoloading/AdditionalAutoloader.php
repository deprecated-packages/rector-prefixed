<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\Autoloading;

use _PhpScopere8e811afab72\Nette\Loaders\RobotLoader;
use _PhpScopere8e811afab72\Rector\Core\Configuration\Option;
use _PhpScopere8e811afab72\Rector\Core\FileSystem\FileGuard;
use _PhpScopere8e811afab72\Symfony\Component\Console\Input\InputInterface;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Parameter\ParameterProvider;
use _PhpScopere8e811afab72\Symplify\Skipper\SkipCriteriaResolver\SkippedPathsResolver;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\FileSystemFilter;
/**
 * Should it pass autoload files/directories to PHPStan analyzer?
 */
final class AdditionalAutoloader
{
    /**
     * @var string[]
     */
    private $autoloadPaths = [];
    /**
     * @var FileGuard
     */
    private $fileGuard;
    /**
     * @var FileSystemFilter
     */
    private $fileSystemFilter;
    /**
     * @var SkippedPathsResolver
     */
    private $skippedPathsResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\FileSystem\FileGuard $fileGuard, \_PhpScopere8e811afab72\Symplify\SmartFileSystem\FileSystemFilter $fileSystemFilter, \_PhpScopere8e811afab72\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \_PhpScopere8e811afab72\Symplify\Skipper\SkipCriteriaResolver\SkippedPathsResolver $skippedPathsResolver)
    {
        $this->fileGuard = $fileGuard;
        $this->autoloadPaths = (array) $parameterProvider->provideParameter(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::AUTOLOAD_PATHS);
        $this->fileSystemFilter = $fileSystemFilter;
        $this->skippedPathsResolver = $skippedPathsResolver;
    }
    /**
     * @param string[] $source
     */
    public function autoloadWithInputAndSource(\_PhpScopere8e811afab72\Symfony\Component\Console\Input\InputInterface $input, array $source) : void
    {
        $autoloadDirectories = $this->fileSystemFilter->filterDirectories($this->autoloadPaths);
        $autoloadFiles = $this->fileSystemFilter->filterFiles($this->autoloadPaths);
        $this->autoloadFileFromInput($input);
        $this->autoloadDirectories($autoloadDirectories);
        $this->autoloadFiles($autoloadFiles);
        // the scanned file needs to be autoloaded
        $directories = $this->fileSystemFilter->filterDirectories($source);
        foreach ($directories as $directory) {
            // load project autoload
            if (\file_exists($directory . '/vendor/autoload.php')) {
                require_once $directory . '/vendor/autoload.php';
            }
        }
    }
    private function autoloadFileFromInput(\_PhpScopere8e811afab72\Symfony\Component\Console\Input\InputInterface $input) : void
    {
        if (!$input->hasOption(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::OPTION_AUTOLOAD_FILE)) {
            return;
        }
        /** @var string|null $autoloadFile */
        $autoloadFile = $input->getOption(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::OPTION_AUTOLOAD_FILE);
        if ($autoloadFile === null) {
            return;
        }
        $this->autoloadFiles([$autoloadFile]);
    }
    /**
     * @param string[] $directories
     */
    private function autoloadDirectories(array $directories) : void
    {
        if ($directories === []) {
            return;
        }
        $robotLoader = new \_PhpScopere8e811afab72\Nette\Loaders\RobotLoader();
        $robotLoader->ignoreDirs[] = '*Fixtures';
        $excludePaths = $this->skippedPathsResolver->resolve();
        foreach ($excludePaths as $excludePath) {
            $robotLoader->ignoreDirs[] = $excludePath;
        }
        // last argument is workaround: https://github.com/nette/robot-loader/issues/12
        $robotLoader->setTempDirectory(\sys_get_temp_dir() . '/_rector_robot_loader');
        $robotLoader->addDirectory(...$directories);
        $robotLoader->register();
    }
    /**
     * @param string[] $files
     */
    private function autoloadFiles(array $files) : void
    {
        foreach ($files as $file) {
            $this->fileGuard->ensureFileExists($file, 'Extra autoload');
            require_once $file;
        }
    }
}
