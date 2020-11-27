<?php

namespace _PhpScopera143bcca66cb\AcceptThrowable;

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
    $foo = new \_PhpScopera143bcca66cb\AcceptThrowable\Foo();
    try {
    } catch (\_PhpScopera143bcca66cb\AcceptThrowable\SomeInterface $e) {
        $foo->doFoo($e);
        $foo->doBar($e);
    } catch (\_PhpScopera143bcca66cb\AcceptThrowable\InterfaceExtendingThrowable $e) {
        $foo->doFoo($e);
        $foo->doBar($e);
    } catch (\_PhpScopera143bcca66cb\AcceptThrowable\NonExceptionClass $e) {
        $foo->doFoo($e);
        // fine, the feasibility must be checked by a different rule
        $foo->doBar($e);
    } catch (\Exception $e) {
        $foo->doFoo($e);
        $foo->doBar($e);
    }
};
