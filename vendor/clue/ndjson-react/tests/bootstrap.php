<?php

namespace _PhpScoper26e51eeacccf;

use _PhpScoper26e51eeacccf\PHPUnit\Framework\TestCase as BaseTestCase;
require_once __DIR__ . '/../vendor/autoload.php';
\error_reporting(-1);
class TestCase extends \_PhpScoper26e51eeacccf\PHPUnit\Framework\TestCase
{
    protected function expectCallableNever()
    {
        $mock = $this->createCallableMock();
        $mock->expects($this->never())->method('__invoke');
        return $mock;
    }
    protected function expectCallableOnce()
    {
        $mock = $this->createCallableMock();
        $mock->expects($this->once())->method('__invoke');
        return $mock;
    }
    protected function expectCallableOnceWith($value)
    {
        $mock = $this->createCallableMock();
        $mock->expects($this->once())->method('__invoke')->with($value);
        return $mock;
    }
    protected function createCallableMock()
    {
        return $this->getMockBuilder('stdClass')->setMethods(array('__invoke'))->getMock();
    }
}
\class_alias('_PhpScoper26e51eeacccf\\TestCase', 'TestCase', \false);
