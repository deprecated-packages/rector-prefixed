<?php

declare (strict_types=1);
/*
 * This file is part of Evenement.
 *
 * (c) Igor Wiedler <igor@wiedler.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Evenement;

interface EventEmitterInterface
{
    public function on($event, callable $listener);
    public function once($event, callable $listener);
    public function removeListener($event, callable $listener);
    public function removeAllListeners($event = null);
    public function listeners($event = null);
    public function emit($event, array $arguments = []);
}