<?php

namespace _PhpScoper26e51eeacccf\StaticCallsToInstanceMethods;

class Foo
{
    public static function doStaticFoo()
    {
        \_PhpScoper26e51eeacccf\StaticCallsToInstanceMethods\Foo::doFoo();
        // cannot call from static context
    }
    public function doFoo()
    {
        \_PhpScoper26e51eeacccf\StaticCallsToInstanceMethods\Foo::doFoo();
        \_PhpScoper26e51eeacccf\StaticCallsToInstanceMethods\Bar::doBar();
        // not guaranteed, works only in instance of Bar
    }
    protected function doProtectedFoo()
    {
    }
    private function doPrivateFoo()
    {
    }
}
class Bar extends \_PhpScoper26e51eeacccf\StaticCallsToInstanceMethods\Foo
{
    public static function doStaticBar()
    {
        \_PhpScoper26e51eeacccf\StaticCallsToInstanceMethods\Foo::doFoo();
        // cannot call from static context
    }
    public function doBar()
    {
        \_PhpScoper26e51eeacccf\StaticCallsToInstanceMethods\Foo::doFoo();
        \_PhpScoper26e51eeacccf\StaticCallsToInstanceMethods\Foo::dofoo();
        \_PhpScoper26e51eeacccf\StaticCallsToInstanceMethods\Foo::doFoo(1);
        \_PhpScoper26e51eeacccf\StaticCallsToInstanceMethods\Foo::doProtectedFoo();
        \_PhpScoper26e51eeacccf\StaticCallsToInstanceMethods\Foo::doPrivateFoo();
        \_PhpScoper26e51eeacccf\StaticCallsToInstanceMethods\Bar::doBar();
        static::doFoo();
        static::doFoo(1);
    }
}
