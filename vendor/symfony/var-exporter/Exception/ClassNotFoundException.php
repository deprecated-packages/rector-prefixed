<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20201231\Symfony\Component\VarExporter\Exception;

class ClassNotFoundException extends \Exception implements \RectorPrefix20201231\Symfony\Component\VarExporter\Exception\ExceptionInterface
{
    public function __construct(string $class, \Throwable $previous = null)
    {
        parent::__construct(\sprintf('Class "%s" not found.', $class), 0, $previous);
    }
}
