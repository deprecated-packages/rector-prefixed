<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210503\Symfony\Component\HttpFoundation\Exception;

/**
 * Raised when a user has performed an operation that should be considered
 * suspicious from a security perspective.
 */
class SuspiciousOperationException extends \UnexpectedValueException implements \RectorPrefix20210503\Symfony\Component\HttpFoundation\Exception\RequestExceptionInterface
{
}
