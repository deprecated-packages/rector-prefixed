<?php

namespace _PhpScopera143bcca66cb\StaticCallsToInstanceMethods;

class Foo
{
    public static function doStaticFoo()
    {
        \_PhpScopera143bcca66cb\StaticCallsToInstanceMethods\Foo::doFoo();
        // cannot call from static context
    }
    public function doFoo()
    {
        \_PhpScopera143bcca66cb\StaticCallsToInstanceMethods\Foo::doFoo();
        \_PhpScopera143bcca66cb\StaticCallsToInstanceMethods\Bar::doBar();
        // not guaranteed, works only in instance of Bar
    }
    protected function doProtectedFoo()
    {
    }
    private function doPrivateFoo()
    {
    }
}
class Bar extends \_PhpScopera143bcca66cb\StaticCallsToInstanceMethods\Foo
{
    public static function doStaticBar()
    {
        \_PhpScopera143bcca66cb\StaticCallsToInstanceMethods\Foo::doFoo();
        // cannot call from static context
    }
    public function doBar()
    {
        \_PhpScopera143bcca66cb\StaticCallsToInstanceMethods\Foo::doFoo();
        \_PhpScopera143bcca66cb\StaticCallsToInstanceMethods\Foo::dofoo();
        \_PhpScopera143bcca66cb\StaticCallsToInstanceMethods\Foo::doFoo(1);
        \_PhpScopera143bcca66cb\StaticCallsToInstanceMethods\Foo::doProtectedFoo();
        \_PhpScopera143bcca66cb\StaticCallsToInstanceMethods\Foo::doPrivateFoo();
        \_PhpScopera143bcca66cb\StaticCallsToInstanceMethods\Bar::doBar();
        static::doFoo();
        static::doFoo(1);
    }
}
