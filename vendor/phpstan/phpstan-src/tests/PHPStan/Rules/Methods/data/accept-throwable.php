<?php

namespace _PhpScoper006a73f0e455\AcceptThrowable;

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
    $foo = new \_PhpScoper006a73f0e455\AcceptThrowable\Foo();
    try {
    } catch (\_PhpScoper006a73f0e455\AcceptThrowable\SomeInterface $e) {
        $foo->doFoo($e);
        $foo->doBar($e);
    } catch (\_PhpScoper006a73f0e455\AcceptThrowable\InterfaceExtendingThrowable $e) {
        $foo->doFoo($e);
        $foo->doBar($e);
    } catch (\_PhpScoper006a73f0e455\AcceptThrowable\NonExceptionClass $e) {
        $foo->doFoo($e);
        // fine, the feasibility must be checked by a different rule
        $foo->doBar($e);
    } catch (\Exception $e) {
        $foo->doFoo($e);
        $foo->doBar($e);
    }
};
