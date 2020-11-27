<?php

namespace _PhpScopera143bcca66cb;

use _PhpScopera143bcca66cb\PHPUnit\Framework\TestCase as BaseTestCase;
require_once __DIR__ . '/../vendor/autoload.php';
\error_reporting(-1);
class TestCase extends \_PhpScopera143bcca66cb\PHPUnit\Framework\TestCase
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
\class_alias('_PhpScopera143bcca66cb\\TestCase', 'TestCase', \false);
