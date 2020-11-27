<?php

/**
 * Hoa
 *
 *
 * @license
 *
 * New BSD License
 *
 * Copyright © 2007-2017, Hoa community. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the Hoa nor the names of its contributors may be
 *       used to endorse or promote products derived from this software without
 *       specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDERS AND CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */
namespace Hoa\Event\Test\Unit;

use Hoa\Event as LUT;
use Hoa\Event\Event as SUT;
use Hoa\Test;
/**
 * Class \Hoa\Event\Test\Unit\Event.
 *
 * Test suite of the event class.
 *
 * @copyright  Copyright © 2007-2017 Hoa community
 * @license    New BSD License
 */
class Event extends \Hoa\Test\Unit\Suite
{
    public function case_multiton()
    {
        $this->given($eventId = 'hoa://Event/Test')->when($result = \Hoa\Event\Event::getEvent($eventId))->then->object($result)->isInstanceOf('Hoa\\Event\\Event')->object(\Hoa\Event\Event::getEvent($eventId))->isIdenticalTo($result);
    }
    public function case_register_source_instance()
    {
        $this->given($eventId = 'hoa://Event/Test', $source = new \_PhpScoper88fe6e0ad041\Mock\Hoa\Event\Source())->when($result = \Hoa\Event\Event::register($eventId, $source))->then->variable($result)->isNull()->boolean(\Hoa\Event\Event::eventExists($eventId))->isTrue();
    }
    public function case_register_source_name()
    {
        $this->given($eventId = 'hoa://Event/Test', $source = '_PhpScoper88fe6e0ad041\\Mock\\Hoa\\Event\\Source')->when($result = \Hoa\Event\Event::register($eventId, $source))->then->variable($result)->isNull()->boolean(\Hoa\Event\Event::eventExists($eventId))->isTrue();
    }
    public function case_register_redeclare()
    {
        $this->given($eventId = 'hoa://Event/Test', $source = new \_PhpScoper88fe6e0ad041\Mock\Hoa\Event\Source(), \Hoa\Event\Event::register($eventId, $source))->exception(function () use($eventId, $source) {
            \Hoa\Event\Event::register($eventId, $source);
        })->isInstanceOf('Hoa\\Event\\Exception');
    }
    public function case_register_not_a_source_instance()
    {
        $this->given($eventId = 'hoa://Event/Test', $source = new \_PhpScoper88fe6e0ad041\StdClass())->exception(function () use($eventId, $source) {
            $result = \Hoa\Event\Event::register($eventId, $source);
        })->isInstanceOf('Hoa\\Event\\Exception');
    }
    public function case_register_not_a_source_name()
    {
        $this->given($eventId = 'hoa://Event/Test', $source = 'StdClass')->exception(function () use($eventId, $source) {
            $result = \Hoa\Event\Event::register($eventId, $source);
        })->isInstanceOf('Hoa\\Event\\Exception');
    }
    public function case_unregister()
    {
        $this->given($eventId = 'hoa://Event/Test', $source = new \_PhpScoper88fe6e0ad041\Mock\Hoa\Event\Source(), \Hoa\Event\Event::register($eventId, $source))->when($result = \Hoa\Event\Event::unregister($eventId))->then->boolean(\Hoa\Event\Event::eventExists($eventId))->isFalse();
    }
    public function case_unregister_hard()
    {
        $this->given($eventId = 'hoa://Event/Test', $source = new \_PhpScoper88fe6e0ad041\Mock\Hoa\Event\Source(), \Hoa\Event\Event::register($eventId, $source), $event = \Hoa\Event\Event::getEvent($eventId))->when($result = \Hoa\Event\Event::unregister($eventId, \true))->then->boolean(\Hoa\Event\Event::eventExists($eventId))->isFalse()->object(\Hoa\Event\Event::getEvent($eventId))->isNotIdenticalTo($event);
    }
    public function case_unregister_not_registered()
    {
        $this->given($eventId = 'hoa://Event/Test')->when($result = \Hoa\Event\Event::unregister($eventId))->then->variable($result)->isNull();
    }
    public function case_attach()
    {
        $this->given($event = \Hoa\Event\Event::getEvent('hoa://Event/Test'), $callable = function () {
        })->when($result = $event->attach($callable))->then->object($result)->isIdenticalTo($event)->boolean($event->isListened())->isTrue();
    }
    public function case_detach()
    {
        $this->given($event = \Hoa\Event\Event::getEvent('hoa://Event/Test'), $callable = function () {
        }, $event->attach($callable))->when($result = $event->detach($callable))->then->object($result)->isIdenticalTo($event)->boolean($event->isListened())->isFalse();
    }
    public function case_detach_unattached()
    {
        $this->given($event = \Hoa\Event\Event::getEvent('hoa://Event/Test'), $callable = function () {
        })->when($result = $event->detach($callable))->then->object($result)->isIdenticalTo($event)->boolean($event->isListened())->isFalse();
    }
    public function case_is_listened()
    {
        $this->given($event = \Hoa\Event\Event::getEvent('hoa://Event/Test'))->when($result = $event->isListened())->then->boolean($event->isListened())->isFalse();
    }
    public function case_notify()
    {
        $self = $this;
        $this->given($eventId = 'hoa://Event/Test', $source = new \_PhpScoper88fe6e0ad041\Mock\Hoa\Event\Source(), $bucket = new \Hoa\Event\Bucket(), \Hoa\Event\Event::register($eventId, $source), \Hoa\Event\Event::getEvent($eventId)->attach(function (\Hoa\Event\Bucket $receivedBucket) use($self, $source, $bucket, &$called) {
            $called = \true;
            $this->object($receivedBucket)->isIdenticalTo($bucket)->object($receivedBucket->getSource())->isIdenticalTo($source);
        }))->when($result = \Hoa\Event\Event::notify($eventId, $source, $bucket))->then->variable($result)->isNull()->boolean($called)->isTrue();
    }
    public function case_notify_unregistered_event_id()
    {
        $this->given($eventId = 'hoa://Event/Test', $source = new \_PhpScoper88fe6e0ad041\Mock\Hoa\Event\Source(), $data = new \Hoa\Event\Bucket())->exception(function () use($eventId, $source, $data) {
            \Hoa\Event\Event::notify($eventId, $source, $data);
        })->isInstanceOf('Hoa\\Event\\Exception');
    }
    public function case_event_exists()
    {
        $this->given($eventId = 'hoa://Event/Test', $source = new \_PhpScoper88fe6e0ad041\Mock\Hoa\Event\Source(), \Hoa\Event\Event::register($eventId, $source))->when($result = \Hoa\Event\Event::eventExists($eventId))->then->boolean($result)->isTrue();
    }
    public function case_event_not_exists()
    {
        $this->given($eventId = 'hoa://Event/Test')->when($result = \Hoa\Event\Event::eventExists($eventId))->then->boolean($result)->isFalse();
    }
}
