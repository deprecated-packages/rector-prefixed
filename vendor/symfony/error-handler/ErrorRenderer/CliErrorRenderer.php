<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix2020DecSat\Symfony\Component\ErrorHandler\ErrorRenderer;

use RectorPrefix2020DecSat\Symfony\Component\ErrorHandler\Exception\FlattenException;
use RectorPrefix2020DecSat\Symfony\Component\VarDumper\Cloner\VarCloner;
use RectorPrefix2020DecSat\Symfony\Component\VarDumper\Dumper\CliDumper;
// Help opcache.preload discover always-needed symbols
\class_exists(\RectorPrefix2020DecSat\Symfony\Component\VarDumper\Dumper\CliDumper::class);
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class CliErrorRenderer implements \RectorPrefix2020DecSat\Symfony\Component\ErrorHandler\ErrorRenderer\ErrorRendererInterface
{
    /**
     * {@inheritdoc}
     */
    public function render(\Throwable $exception) : \RectorPrefix2020DecSat\Symfony\Component\ErrorHandler\Exception\FlattenException
    {
        $cloner = new \RectorPrefix2020DecSat\Symfony\Component\VarDumper\Cloner\VarCloner();
        $dumper = new class extends \RectorPrefix2020DecSat\Symfony\Component\VarDumper\Dumper\CliDumper
        {
            protected function supportsColors() : bool
            {
                $outputStream = $this->outputStream;
                $this->outputStream = \fopen('php://stdout', 'w');
                try {
                    return parent::supportsColors();
                } finally {
                    $this->outputStream = $outputStream;
                }
            }
        };
        return \RectorPrefix2020DecSat\Symfony\Component\ErrorHandler\Exception\FlattenException::createFromThrowable($exception)->setAsString($dumper->dump($cloner->cloneVar($exception), \true));
    }
}
