<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210317\Symfony\Component\Console\Event;

use RectorPrefix20210317\Symfony\Component\Console\Command\Command;
use RectorPrefix20210317\Symfony\Component\Console\Input\InputInterface;
use RectorPrefix20210317\Symfony\Component\Console\Output\OutputInterface;
/**
 * @author marie <marie@users.noreply.github.com>
 */
final class ConsoleSignalEvent extends \RectorPrefix20210317\Symfony\Component\Console\Event\ConsoleEvent
{
    private $handlingSignal;
    /**
     * @param \Symfony\Component\Console\Command\Command $command
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param int $handlingSignal
     */
    public function __construct($command, $input, $output, $handlingSignal)
    {
        parent::__construct($command, $input, $output);
        $this->handlingSignal = $handlingSignal;
    }
    public function getHandlingSignal() : int
    {
        return $this->handlingSignal;
    }
}
