<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperbd5d0c5f7638\Symfony\Component\VarDumper;

use _PhpScoperbd5d0c5f7638\Symfony\Component\VarDumper\Caster\ReflectionCaster;
use _PhpScoperbd5d0c5f7638\Symfony\Component\VarDumper\Cloner\VarCloner;
use _PhpScoperbd5d0c5f7638\Symfony\Component\VarDumper\Dumper\CliDumper;
use _PhpScoperbd5d0c5f7638\Symfony\Component\VarDumper\Dumper\ContextProvider\SourceContextProvider;
use _PhpScoperbd5d0c5f7638\Symfony\Component\VarDumper\Dumper\ContextualizedDumper;
use _PhpScoperbd5d0c5f7638\Symfony\Component\VarDumper\Dumper\HtmlDumper;
// Load the global dump() function
require_once __DIR__ . '/Resources/functions/dump.php';
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class VarDumper
{
    private static $handler;
    public static function dump($var)
    {
        if (null === self::$handler) {
            $cloner = new \_PhpScoperbd5d0c5f7638\Symfony\Component\VarDumper\Cloner\VarCloner();
            $cloner->addCasters(\_PhpScoperbd5d0c5f7638\Symfony\Component\VarDumper\Caster\ReflectionCaster::UNSET_CLOSURE_FILE_INFO);
            if (isset($_SERVER['VAR_DUMPER_FORMAT'])) {
                $dumper = 'html' === $_SERVER['VAR_DUMPER_FORMAT'] ? new \_PhpScoperbd5d0c5f7638\Symfony\Component\VarDumper\Dumper\HtmlDumper() : new \_PhpScoperbd5d0c5f7638\Symfony\Component\VarDumper\Dumper\CliDumper();
            } else {
                $dumper = \in_array(\PHP_SAPI, ['cli', 'phpdbg']) ? new \_PhpScoperbd5d0c5f7638\Symfony\Component\VarDumper\Dumper\CliDumper() : new \_PhpScoperbd5d0c5f7638\Symfony\Component\VarDumper\Dumper\HtmlDumper();
            }
            $dumper = new \_PhpScoperbd5d0c5f7638\Symfony\Component\VarDumper\Dumper\ContextualizedDumper($dumper, [new \_PhpScoperbd5d0c5f7638\Symfony\Component\VarDumper\Dumper\ContextProvider\SourceContextProvider()]);
            self::$handler = function ($var) use($cloner, $dumper) {
                $dumper->dump($cloner->cloneVar($var));
            };
        }
        return (self::$handler)($var);
    }
    public static function setHandler(callable $callable = null)
    {
        $prevHandler = self::$handler;
        // Prevent replacing the handler with expected format as soon as the env var was set:
        if (isset($_SERVER['VAR_DUMPER_FORMAT'])) {
            return $prevHandler;
        }
        self::$handler = $callable;
        return $prevHandler;
    }
}
