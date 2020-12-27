<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Command;

use RectorPrefix20201227\PHPStan\Analyser\ResultCache\ResultCacheClearer;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Command\Command;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Input\InputInterface;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Input\InputOption;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Output\OutputInterface;
class ClearResultCacheCommand extends \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Command\Command
{
    private const NAME = 'clear-result-cache';
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
        $this->setName(self::NAME)->setDescription('Clears the result cache.')->setDefinition([new \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Input\InputOption('configuration', 'c', \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Path to project configuration file'), new \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Input\InputOption('autoload-file', 'a', \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Project\'s additional autoload file path')]);
    }
    protected function execute(\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Input\InputInterface $input, \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $autoloadFile = $input->getOption('autoload-file');
        $configuration = $input->getOption('configuration');
        if (!\is_string($autoloadFile) && $autoloadFile !== null || !\is_string($configuration) && $configuration !== null) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        try {
            $inceptionResult = \RectorPrefix20201227\PHPStan\Command\CommandHelper::begin($input, $output, ['.'], null, null, $autoloadFile, $this->composerAutoloaderProjectPaths, $configuration, null, '0', \false, \false);
        } catch (\RectorPrefix20201227\PHPStan\Command\InceptionNotSuccessfulException $e) {
            return 1;
        }
        $container = $inceptionResult->getContainer();
        /** @var ResultCacheClearer $resultCacheClearer */
        $resultCacheClearer = $container->getByType(\RectorPrefix20201227\PHPStan\Analyser\ResultCache\ResultCacheClearer::class);
        $path = $resultCacheClearer->clear();
        $output->writeln('<info>Result cache cleared from directory:</info>');
        $output->writeln($path);
        return 0;
    }
}
