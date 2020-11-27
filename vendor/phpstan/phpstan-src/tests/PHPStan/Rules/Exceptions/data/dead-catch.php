<?php

namespace _PhpScoper88fe6e0ad041\DeadCatch;

class Foo
{
    public function doFoo()
    {
        try {
        } catch (\Exception $e) {
        } catch (\TypeError $e) {
        } catch (\Throwable $t) {
        }
    }
    public function doBar()
    {
        try {
        } catch (\Throwable $e) {
        } catch (\TypeError $e) {
        }
    }
}
