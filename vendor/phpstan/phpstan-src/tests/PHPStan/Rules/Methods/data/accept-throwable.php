<?php

namespace _PhpScoper88fe6e0ad041\AcceptThrowable;

interface SomeInterface
{
}
interface InterfaceExtendingThrowable extends \Throwable
{
}
class NonExceptionClass
{
}
class Foo
{
    public function doFoo(\Throwable $e)
    {
    }
    public function doBar(int $i)
    {
    }
}
function () {
    $foo = new \_PhpScoper88fe6e0ad041\AcceptThrowable\Foo();
    try {
    } catch (\_PhpScoper88fe6e0ad041\AcceptThrowable\SomeInterface $e) {
        $foo->doFoo($e);
        $foo->doBar($e);
    } catch (\_PhpScoper88fe6e0ad041\AcceptThrowable\InterfaceExtendingThrowable $e) {
        $foo->doFoo($e);
        $foo->doBar($e);
    } catch (\_PhpScoper88fe6e0ad041\AcceptThrowable\NonExceptionClass $e) {
        $foo->doFoo($e);
        // fine, the feasibility must be checked by a different rule
        $foo->doBar($e);
    } catch (\Exception $e) {
        $foo->doFoo($e);
        $foo->doBar($e);
    }
};
