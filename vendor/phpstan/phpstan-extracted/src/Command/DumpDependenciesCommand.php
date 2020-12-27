<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Command;

use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Nette\Utils\Json;
use RectorPrefix20201227\PHPStan\Dependency\DependencyDumper;
use RectorPrefix20201227\PHPStan\File\FileHelper;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputArgument;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputInterface;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Output\OutputInterface;
class DumpDependenciesCommand extends \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Command\Command
{
    private const NAME = 'dump-deps';
    /** @var string[] */
    private $composerAutoloaderProjectPaths;
    /**
     * @param string[] $composerAutoloaderProjectPaths
     */
    public function __construct(array $composerAutoloaderProjectPaths)
    {
        parent::__construct();
        $this->composerAutoloaderProjectPaths = $composerAutoloaderProjectPaths;
    }
    protected function configure() : void
    {
        $this->setName(self::NAME)->setDescription('Dumps files dependency tree')->setDefinition([new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputArgument('paths', \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputArgument::OPTIONAL | \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputArgument::IS_ARRAY, 'Paths with source code to run dump on'), new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption('paths-file', null, \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Path to a file with a list of paths to run analysis on'), new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption('configuration', 'c', \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Path to project configuration file'), new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption(\RectorPrefix20201227\PHPStan\Command\ErrorsConsoleStyle::OPTION_NO_PROGRESS, null, \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Do not show progress bar, only results'), new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption('autoload-file', 'a', \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Project\'s additional autoload file path'), new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption('memory-limit', null, \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Memory limit for the run'), new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption('analysed-paths', null, \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption::VALUE_IS_ARRAY | \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Project-scope paths'), new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption('xdebug', null, \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Allow running with XDebug for debugging purposes')]);
    }
    protected function execute(\RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Input\InputInterface $input, \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        try {
            /** @var string[] $paths */
            $paths = $input->getArgument('paths');
            /** @var string|null $memoryLimit */
            $memoryLimit = $input->getOption('memory-limit');
            /** @var string|null $autoloadFile */
            $autoloadFile = $input->getOption('autoload-file');
            /** @var string|null $configurationFile */
            $configurationFile = $input->getOption('configuration');
            /** @var string|null $pathsFile */
            $pathsFile = $input->getOption('paths-file');
            /** @var bool $allowXdebug */
            $allowXdebug = $input->getOption('xdebug');
            $inceptionResult = \RectorPrefix20201227\PHPStan\Command\CommandHelper::begin(
                $input,
                $output,
                $paths,
                $pathsFile,
                $memoryLimit,
                $autoloadFile,
                $this->composerAutoloaderProjectPaths,
                $configurationFile,
                null,
                '0',
                // irrelevant but prevents an error when a config file is passed
                $allowXdebug,
                \true
            );
        } catch (\RectorPrefix20201227\PHPStan\Command\InceptionNotSuccessfulException $e) {
            return 1;
        }
        try {
            [$files] = $inceptionResult->getFiles();
        } catch (\RectorPrefix20201227\PHPStan\File\PathNotFoundException $e) {
            $inceptionResult->getErrorOutput()->writeLineFormatted(\sprintf('<error>%s</error>', $e->getMessage()));
            return 1;
        }
        $stdOutput = $inceptionResult->getStdOutput();
        $stdOutputStyole = $stdOutput->getStyle();
        /** @var DependencyDumper $dependencyDumper */
        $dependencyDumper = $inceptionResult->getContainer()->getByType(\RectorPrefix20201227\PHPStan\Dependency\DependencyDumper::class);
        /** @var FileHelper $fileHelper */
        $fileHelper = $inceptionResult->getContainer()->getByType(\RectorPrefix20201227\PHPStan\File\FileHelper::class);
        /** @var string[] $analysedPaths */
        $analysedPaths = $input->getOption('analysed-paths');
        $analysedPaths = \array_map(static function (string $path) use($fileHelper) : string {
            return $fileHelper->absolutizePath($path);
        }, $analysedPaths);
        $dependencies = $dependencyDumper->dumpDependencies($files, static function (int $count) use($stdOutputStyole) : void {
            $stdOutputStyole->progressStart($count);
        }, static function () use($stdOutputStyole) : void {
            $stdOutputStyole->progressAdvance();
        }, \count($analysedPaths) > 0 ? $analysedPaths : null);
        $stdOutputStyole->progressFinish();
        $stdOutput->writeLineFormatted(\RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Nette\Utils\Json::encode($dependencies, \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Nette\Utils\Json::PRETTY));
        return $inceptionResult->handleReturn(0);
    }
}
