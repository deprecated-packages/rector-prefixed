<?php

declare(strict_types=1);

namespace Rector\ChangesReporting\ValueObjectFactory;

use PHPStan\AnalysedCodeException;
use Rector\Core\Error\ExceptionCorrector;
use Rector\Core\ValueObject\Application\RectorError;

final class ErrorFactory
{
    /**
     * @var ExceptionCorrector
     */
    private $exceptionCorrector;

    public function __construct(ExceptionCorrector $exceptionCorrector)
    {
        $this->exceptionCorrector = $exceptionCorrector;
    }

    public function createAutoloadError(AnalysedCodeException $analysedCodeException): RectorError
    {
        $message = $this->exceptionCorrector->getAutoloadExceptionMessageAndAddLocation($analysedCodeException);
        return new RectorError($message);
    }
}
