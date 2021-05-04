<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210504\Symfony\Component\HttpFoundation\Exception;

/**
 * Raised when a user sends a malformed request.
 */
class BadRequestException extends \UnexpectedValueException implements \RectorPrefix20210504\Symfony\Component\HttpFoundation\Exception\RequestExceptionInterface
{
}
