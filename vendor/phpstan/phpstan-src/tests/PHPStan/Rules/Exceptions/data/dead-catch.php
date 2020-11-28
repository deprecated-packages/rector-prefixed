<?php

namespace _PhpScoperabd03f0baf05\DeadCatch;

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
