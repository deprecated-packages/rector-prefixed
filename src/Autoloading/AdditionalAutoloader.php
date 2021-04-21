<?php

declare (strict_types=1);
namespace Rector\Core\Autoloading;

use Rector\Core\Configuration\Option;
use Rector\Core\StaticReflection\DynamicSourceLocatorDecorator;
use RectorPrefix20210421\Symfony\Component\Console\Input\InputInterface;
use RectorPrefix20210421\Symplify\PackageBuilder\Parameter\ParameterProvider;
use RectorPrefix20210421\Symplify\SmartFileSystem\FileSystemGuard;
/**
 * Should it pass autoload files/directories to PHPStan analyzer?
 */
final class AdditionalAutoloader
{
    /**
     * @var FileSystemGuard
     */
    private $fileSystemGuard;
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    /**
     * @var DynamicSourceLocatorDecorator
     */
    private $dynamicSourceLocatorDecorator;
    public function __construct(\RectorPrefix20210421\Symplify\SmartFileSystem\FileSystemGuard $fileSystemGuard, \RectorPrefix20210421\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, \Rector\Core\StaticReflection\DynamicSourceLocatorDecorator $dynamicSourceLocatorDecorator)
    {
        $this->fileSystemGuard = $fileSystemGuard;
        $this->parameterProvider = $parameterProvider;
        $this->dynamicSourceLocatorDecorator = $dynamicSourceLocatorDecorator;
    }
    /**
     * @return void
     */
    public function autoloadWithInputAndSource(\RectorPrefix20210421\Symfony\Component\Console\Input\InputInterface $input)
    {
        if ($input->hasOption(\Rector\Core\Configuration\Option::OPTION_AUTOLOAD_FILE)) {
            $this->autoloadInputAutoloadFile($input);
        }
        $autoloadPaths = $this->parameterProvider->provideArrayParameter(\Rector\Core\Configuration\Option::AUTOLOAD_PATHS);
        if ($autoloadPaths === []) {
            return;
        }
        $this->dynamicSourceLocatorDecorator->addPaths($autoloadPaths);
    }
    /**
     * @return void
     */
    private function autoloadInputAutoloadFile(\RectorPrefix20210421\Symfony\Component\Console\Input\InputInterface $input)
    {
        /** @var string|null $autoloadFile */
        $autoloadFile = $input->getOption(\Rector\Core\Configuration\Option::OPTION_AUTOLOAD_FILE);
        if ($autoloadFile === null) {
            return;
        }
        $this->fileSystemGuard->ensureFileExists($autoloadFile, 'Extra autoload');
        $this->dynamicSourceLocatorDecorator->addPaths([$autoloadFile]);
    }
}
