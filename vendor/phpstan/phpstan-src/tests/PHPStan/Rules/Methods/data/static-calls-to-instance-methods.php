<?php

namespace _PhpScoperbd5d0c5f7638\StaticCallsToInstanceMethods;

class Foo
{
    public static function doStaticFoo()
    {
        \_PhpScoperbd5d0c5f7638\StaticCallsToInstanceMethods\Foo::doFoo();
        // cannot call from static context
    }
    public function doFoo()
    {
        \_PhpScoperbd5d0c5f7638\StaticCallsToInstanceMethods\Foo::doFoo();
        \_PhpScoperbd5d0c5f7638\StaticCallsToInstanceMethods\Bar::doBar();
        // not guaranteed, works only in instance of Bar
    }
    protected function doProtectedFoo()
    {
    }
    private function doPrivateFoo()
    {
    }
}
class Bar extends \_PhpScoperbd5d0c5f7638\StaticCallsToInstanceMethods\Foo
{
    public static function doStaticBar()
    {
        \_PhpScoperbd5d0c5f7638\StaticCallsToInstanceMethods\Foo::doFoo();
        // cannot call from static context
    }
    public function doBar()
    {
        \_PhpScoperbd5d0c5f7638\StaticCallsToInstanceMethods\Foo::doFoo();
        \_PhpScoperbd5d0c5f7638\StaticCallsToInstanceMethods\Foo::dofoo();
        \_PhpScoperbd5d0c5f7638\StaticCallsToInstanceMethods\Foo::doFoo(1);
        \_PhpScoperbd5d0c5f7638\StaticCallsToInstanceMethods\Foo::doProtectedFoo();
        \_PhpScoperbd5d0c5f7638\StaticCallsToInstanceMethods\Foo::doPrivateFoo();
        \_PhpScoperbd5d0c5f7638\StaticCallsToInstanceMethods\Bar::doBar();
        static::doFoo();
        static::doFoo(1);
    }
}
