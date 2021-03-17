<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210317\Symfony\Component\Filesystem\Exception;

/**
 * Exception class thrown when a file couldn't be found.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Christian Gärtner <christiangaertner.film@googlemail.com>
 */
class FileNotFoundException extends \RectorPrefix20210317\Symfony\Component\Filesystem\Exception\IOException
{
    /**
     * @param string $message
     * @param int $code
     * @param \Throwable $previous
     * @param string $path
     */
    public function __construct($message = null, $code = 0, $previous = null, $path = null)
    {
        if (null === $message) {
            if (null === $path) {
                $message = 'File could not be found.';
            } else {
                $message = \sprintf('File "%s" could not be found.', $path);
            }
        }
        parent::__construct($message, $code, $previous, $path);
    }
}
