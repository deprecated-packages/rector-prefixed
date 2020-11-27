<?php

namespace _PhpScoper88fe6e0ad041\StaticCallsToInstanceMethods;

class Foo
{
    public static function doStaticFoo()
    {
        \_PhpScoper88fe6e0ad041\StaticCallsToInstanceMethods\Foo::doFoo();
        // cannot call from static context
    }
    public function doFoo()
    {
        \_PhpScoper88fe6e0ad041\StaticCallsToInstanceMethods\Foo::doFoo();
        \_PhpScoper88fe6e0ad041\StaticCallsToInstanceMethods\Bar::doBar();
        // not guaranteed, works only in instance of Bar
    }
    protected function doProtectedFoo()
    {
    }
    private function doPrivateFoo()
    {
    }
}
class Bar extends \_PhpScoper88fe6e0ad041\StaticCallsToInstanceMethods\Foo
{
    public static function doStaticBar()
    {
        \_PhpScoper88fe6e0ad041\StaticCallsToInstanceMethods\Foo::doFoo();
        // cannot call from static context
    }
    public function doBar()
    {
        \_PhpScoper88fe6e0ad041\StaticCallsToInstanceMethods\Foo::doFoo();
        \_PhpScoper88fe6e0ad041\StaticCallsToInstanceMethods\Foo::dofoo();
        \_PhpScoper88fe6e0ad041\StaticCallsToInstanceMethods\Foo::doFoo(1);
        \_PhpScoper88fe6e0ad041\StaticCallsToInstanceMethods\Foo::doProtectedFoo();
        \_PhpScoper88fe6e0ad041\StaticCallsToInstanceMethods\Foo::doPrivateFoo();
        \_PhpScoper88fe6e0ad041\StaticCallsToInstanceMethods\Bar::doBar();
        static::doFoo();
        static::doFoo(1);
    }
}
