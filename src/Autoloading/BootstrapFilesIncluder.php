<?php

declare (strict_types=1);
namespace Rector\Core\Autoloading;

use Rector\Core\Configuration\Option;
use Rector\Core\Exception\ShouldNotHappenException;
use RectorPrefix20210421\Symplify\PackageBuilder\Parameter\ParameterProvider;
use Throwable;
final class BootstrapFilesIncluder
{
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    public function __construct(\RectorPrefix20210421\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider)
    {
        $this->parameterProvider = $parameterProvider;
    }
    /**
     * Inspired by
     * @see https://github.com/phpstan/phpstan-src/commit/aad1bf888ab7b5808898ee5fe2228bb8bb4e4cf1
     */
    public function includeBootstrapFiles() : void
    {
        $bootstrapFiles = $this->parameterProvider->provideArrayParameter(\Rector\Core\Configuration\Option::BOOTSTRAP_FILES);
        foreach ($bootstrapFiles as $bootstrapFile) {
            if (!\is_file($bootstrapFile)) {
                throw new \Rector\Core\Exception\ShouldNotHappenException('Bootstrap file %s does not exist.', $bootstrapFile);
            }
            try {
                require_once $bootstrapFile;
            } catch (\Throwable $throwable) {
                $errorMessage = \sprintf('"%s" thrown in "%s" on line %d while loading bootstrap file %s: %s', \get_class($throwable), $throwable->getFile(), $throwable->getLine(), $bootstrapFile, $throwable->getMessage());
                throw new \Rector\Core\Exception\ShouldNotHappenException($errorMessage, $throwable->getCode(), $throwable);
            }
        }
    }
}
