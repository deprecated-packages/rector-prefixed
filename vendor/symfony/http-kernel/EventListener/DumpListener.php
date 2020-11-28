<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperabd03f0baf05\Symfony\Component\HttpKernel\EventListener;

use _PhpScoperabd03f0baf05\Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use _PhpScoperabd03f0baf05\Symfony\Component\VarDumper\Cloner\ClonerInterface;
use _PhpScoperabd03f0baf05\Symfony\Component\VarDumper\Dumper\DataDumperInterface;
use _PhpScoperabd03f0baf05\Symfony\Component\VarDumper\Server\Connection;
use _PhpScoperabd03f0baf05\Symfony\Component\VarDumper\VarDumper;
/**
 * Configures dump() handler.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
class DumpListener implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    private $cloner;
    private $dumper;
    private $connection;
    public function __construct(\_PhpScoperabd03f0baf05\Symfony\Component\VarDumper\Cloner\ClonerInterface $cloner, \_PhpScoperabd03f0baf05\Symfony\Component\VarDumper\Dumper\DataDumperInterface $dumper, \_PhpScoperabd03f0baf05\Symfony\Component\VarDumper\Server\Connection $connection = null)
    {
        $this->cloner = $cloner;
        $this->dumper = $dumper;
        $this->connection = $connection;
    }
    public function configure()
    {
        $cloner = $this->cloner;
        $dumper = $this->dumper;
        $connection = $this->connection;
        \_PhpScoperabd03f0baf05\Symfony\Component\VarDumper\VarDumper::setHandler(static function ($var) use($cloner, $dumper, $connection) {
            $data = $cloner->cloneVar($var);
            if (!$connection || !$connection->write($data)) {
                $dumper->dump($data);
            }
        });
    }
    public static function getSubscribedEvents()
    {
        if (!\class_exists(\_PhpScoperabd03f0baf05\Symfony\Component\Console\ConsoleEvents::class)) {
            return [];
        }
        // Register early to have a working dump() as early as possible
        return [\_PhpScoperabd03f0baf05\Symfony\Component\Console\ConsoleEvents::COMMAND => ['configure', 1024]];
    }
}
