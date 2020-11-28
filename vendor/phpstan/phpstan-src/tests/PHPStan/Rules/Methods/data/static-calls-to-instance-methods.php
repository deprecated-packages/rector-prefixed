<?php

namespace _PhpScoperabd03f0baf05\StaticCallsToInstanceMethods;

class Foo
{
    public static function doStaticFoo()
    {
        \_PhpScoperabd03f0baf05\StaticCallsToInstanceMethods\Foo::doFoo();
        // cannot call from static context
    }
    public function doFoo()
    {
        \_PhpScoperabd03f0baf05\StaticCallsToInstanceMethods\Foo::doFoo();
        \_PhpScoperabd03f0baf05\StaticCallsToInstanceMethods\Bar::doBar();
        // not guaranteed, works only in instance of Bar
    }
    protected function doProtectedFoo()
    {
    }
    private function doPrivateFoo()
    {
    }
}
class Bar extends \_PhpScoperabd03f0baf05\StaticCallsToInstanceMethods\Foo
{
    public static function doStaticBar()
    {
        \_PhpScoperabd03f0baf05\StaticCallsToInstanceMethods\Foo::doFoo();
        // cannot call from static context
    }
    public function doBar()
    {
        \_PhpScoperabd03f0baf05\StaticCallsToInstanceMethods\Foo::doFoo();
        \_PhpScoperabd03f0baf05\StaticCallsToInstanceMethods\Foo::dofoo();
        \_PhpScoperabd03f0baf05\StaticCallsToInstanceMethods\Foo::doFoo(1);
        \_PhpScoperabd03f0baf05\StaticCallsToInstanceMethods\Foo::doProtectedFoo();
        \_PhpScoperabd03f0baf05\StaticCallsToInstanceMethods\Foo::doPrivateFoo();
        \_PhpScoperabd03f0baf05\StaticCallsToInstanceMethods\Bar::doBar();
        static::doFoo();
        static::doFoo(1);
    }
}
