<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210316\Symfony\Polyfill\Util;

use RectorPrefix20210316\PHPUnit\Framework\AssertionFailedError;
use RectorPrefix20210316\PHPUnit\Framework\Test;
use RectorPrefix20210316\PHPUnit\Framework\TestListener as TestListenerInterface;
use RectorPrefix20210316\PHPUnit\Framework\TestSuite;
use RectorPrefix20210316\PHPUnit\Framework\Warning;
use RectorPrefix20210316\PHPUnit\Framework\WarningTestCase;
/**
 * @author Ion Bazan <ion.bazan@gmail.com>
 */
class TestListenerForV7 extends \RectorPrefix20210316\PHPUnit\Framework\TestSuite implements \RectorPrefix20210316\PHPUnit\Framework\TestListener
{
    private $suite;
    private $trait;
    public function __construct(\RectorPrefix20210316\PHPUnit\Framework\TestSuite $suite = null)
    {
        if ($suite) {
            $this->suite = $suite;
            $this->setName($suite->getName() . ' with polyfills enabled');
            $this->addTest($suite);
        }
        $this->trait = new \RectorPrefix20210316\Symfony\Polyfill\Util\TestListenerTrait();
    }
    public function startTestSuite(\RectorPrefix20210316\PHPUnit\Framework\TestSuite $suite) : void
    {
        $this->trait->startTestSuite($suite);
    }
    public function addError(\RectorPrefix20210316\PHPUnit\Framework\Test $test, \Throwable $t, float $time) : void
    {
        $this->trait->addError($test, $t, $time);
    }
    public function addWarning(\RectorPrefix20210316\PHPUnit\Framework\Test $test, \RectorPrefix20210316\PHPUnit\Framework\Warning $e, float $time) : void
    {
    }
    public function addFailure(\RectorPrefix20210316\PHPUnit\Framework\Test $test, \RectorPrefix20210316\PHPUnit\Framework\AssertionFailedError $e, float $time) : void
    {
        $this->trait->addError($test, $e, $time);
    }
    public function addIncompleteTest(\RectorPrefix20210316\PHPUnit\Framework\Test $test, \Throwable $t, float $time) : void
    {
    }
    public function addRiskyTest(\RectorPrefix20210316\PHPUnit\Framework\Test $test, \Throwable $t, float $time) : void
    {
    }
    public function addSkippedTest(\RectorPrefix20210316\PHPUnit\Framework\Test $test, \Throwable $t, float $time) : void
    {
    }
    public function endTestSuite(\RectorPrefix20210316\PHPUnit\Framework\TestSuite $suite) : void
    {
    }
    public function startTest(\RectorPrefix20210316\PHPUnit\Framework\Test $test) : void
    {
    }
    public function endTest(\RectorPrefix20210316\PHPUnit\Framework\Test $test, float $time) : void
    {
    }
    public static function warning($message) : \RectorPrefix20210316\PHPUnit\Framework\WarningTestCase
    {
        return new \RectorPrefix20210316\PHPUnit\Framework\WarningTestCase($message);
    }
    protected function setUp() : void
    {
        \RectorPrefix20210316\Symfony\Polyfill\Util\TestListenerTrait::$enabledPolyfills = $this->suite->getName();
    }
    protected function tearDown() : void
    {
        \RectorPrefix20210316\Symfony\Polyfill\Util\TestListenerTrait::$enabledPolyfills = \false;
    }
}
