<?php

namespace _PhpScoper88fe6e0ad041\Levels\ThrowValues;

class InvalidException
{
}
interface InvalidInterfaceException
{
}
interface ValidInterfaceException extends \Throwable
{
}
class Foo
{
    /**
     * @param ValidInterfaceException $validInterface
     * @param InvalidInterfaceException $invalidInterface
     * @param \Exception|null $nullableException
     * @param \Throwable|int $throwableOrInt
     * @param int|string $intOrString
     */
    public function doFoo(\_PhpScoper88fe6e0ad041\Levels\ThrowValues\ValidInterfaceException $validInterface, \_PhpScoper88fe6e0ad041\Levels\ThrowValues\InvalidInterfaceException $invalidInterface, ?\Exception $nullableException, $throwableOrInt, $intOrString)
    {
        if (\rand(0, 1)) {
            throw new \Exception();
        }
        if (\rand(0, 1)) {
            throw $validInterface;
        }
        if (\rand(0, 1)) {
            throw 123;
        }
        if (\rand(0, 1)) {
            throw new \_PhpScoper88fe6e0ad041\Levels\ThrowValues\InvalidException();
        }
        if (\rand(0, 1)) {
            throw $invalidInterface;
        }
        if (\rand(0, 1)) {
            throw $nullableException;
        }
        if (\rand(0, 1)) {
            throw $throwableOrInt;
        }
        if (\rand(0, 1)) {
            throw $intOrString;
        }
    }
}
