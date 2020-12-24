<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\Error;

use _PhpScoper0a6b37af0871\PHPStan\AnalysedCodeException;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\RectorInterface;
use Throwable;
final class ExceptionCorrector
{
    public function matchRectorClass(\Throwable $throwable) : ?string
    {
        if (!isset($throwable->getTrace()[0])) {
            return null;
        }
        if (!isset($throwable->getTrace()[0]['class'])) {
            return null;
        }
        /** @var string $class */
        $class = $throwable->getTrace()[0]['class'];
        if (!\is_a($class, \_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\RectorInterface::class, \true)) {
            return null;
        }
        return $class;
    }
    public function getAutoloadExceptionMessageAndAddLocation(\_PhpScoper0a6b37af0871\PHPStan\AnalysedCodeException $analysedCodeException) : string
    {
        return \sprintf('Analyze error: "%s". Include your files in "$parameters->set(Option::AUTOLOAD_PATHS, [...]);" in "rector.php" config.%sSee https://github.com/rectorphp/rector#configuration', $analysedCodeException->getMessage(), \PHP_EOL);
    }
}
