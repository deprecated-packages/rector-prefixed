<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix2020DecSat\Symfony\Component\Console\Event;

use RectorPrefix2020DecSat\Symfony\Component\Console\Command\Command;
use RectorPrefix2020DecSat\Symfony\Component\Console\Input\InputInterface;
use RectorPrefix2020DecSat\Symfony\Component\Console\Output\OutputInterface;
/**
 * @author marie <marie@users.noreply.github.com>
 */
final class ConsoleSignalEvent extends \RectorPrefix2020DecSat\Symfony\Component\Console\Event\ConsoleEvent
{
    private $handlingSignal;
    public function __construct(\RectorPrefix2020DecSat\Symfony\Component\Console\Command\Command $command, \RectorPrefix2020DecSat\Symfony\Component\Console\Input\InputInterface $input, \RectorPrefix2020DecSat\Symfony\Component\Console\Output\OutputInterface $output, int $handlingSignal)
    {
        parent::__construct($command, $input, $output);
        $this->handlingSignal = $handlingSignal;
    }
    public function getHandlingSignal() : int
    {
        return $this->handlingSignal;
    }
}
