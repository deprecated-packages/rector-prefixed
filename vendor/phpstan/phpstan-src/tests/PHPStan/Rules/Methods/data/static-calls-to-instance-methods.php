<?php

namespace _PhpScoper006a73f0e455\StaticCallsToInstanceMethods;

class Foo
{
    public static function doStaticFoo()
    {
        \_PhpScoper006a73f0e455\StaticCallsToInstanceMethods\Foo::doFoo();
        // cannot call from static context
    }
    public function doFoo()
    {
        \_PhpScoper006a73f0e455\StaticCallsToInstanceMethods\Foo::doFoo();
        \_PhpScoper006a73f0e455\StaticCallsToInstanceMethods\Bar::doBar();
        // not guaranteed, works only in instance of Bar
    }
    protected function doProtectedFoo()
    {
    }
    private function doPrivateFoo()
    {
    }
}
class Bar extends \_PhpScoper006a73f0e455\StaticCallsToInstanceMethods\Foo
{
    public static function doStaticBar()
    {
        \_PhpScoper006a73f0e455\StaticCallsToInstanceMethods\Foo::doFoo();
        // cannot call from static context
    }
    public function doBar()
    {
        \_PhpScoper006a73f0e455\StaticCallsToInstanceMethods\Foo::doFoo();
        \_PhpScoper006a73f0e455\StaticCallsToInstanceMethods\Foo::dofoo();
        \_PhpScoper006a73f0e455\StaticCallsToInstanceMethods\Foo::doFoo(1);
        \_PhpScoper006a73f0e455\StaticCallsToInstanceMethods\Foo::doProtectedFoo();
        \_PhpScoper006a73f0e455\StaticCallsToInstanceMethods\Foo::doPrivateFoo();
        \_PhpScoper006a73f0e455\StaticCallsToInstanceMethods\Bar::doBar();
        static::doFoo();
        static::doFoo(1);
    }
}
