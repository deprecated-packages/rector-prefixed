<?php

namespace _PhpScopera143bcca66cb\NegatedInstanceOf;

class Foo
{
    public function someMethod($foo, $bar, $otherBar, $lorem, $otherLorem, $dolor, $sit, $mixedFoo, $mixedBar, $self, $static, $anotherFoo, $fooAndBar)
    {
        if (!$foo instanceof \_PhpScopera143bcca66cb\NegatedInstanceOf\Foo) {
            return;
        }
        if (!$bar instanceof \_PhpScopera143bcca66cb\NegatedInstanceOf\Bar || \get_class($bar) !== \get_class($otherBar)) {
            return;
        }
        if (!($lorem instanceof \_PhpScopera143bcca66cb\NegatedInstanceOf\Lorem || \get_class($lorem) === \get_class($otherLorem))) {
            // still mixed after if
            return;
        }
        if ($dolor instanceof \_PhpScopera143bcca66cb\NegatedInstanceOf\Dolor) {
            // still mixed after if
            return;
        }
        if (!!$sit instanceof \_PhpScopera143bcca66cb\NegatedInstanceOf\Sit) {
            // still mixed after if
            return;
        }
        if ($mixedFoo instanceof \_PhpScopera143bcca66cb\NegatedInstanceOf\Foo && doFoo()) {
            return;
        }
        if (!$mixedBar instanceof \_PhpScopera143bcca66cb\NegatedInstanceOf\Bar && doFoo()) {
            return;
        }
        if (!$self instanceof self) {
            return;
        }
        if (!$static instanceof static) {
            return;
        }
        if ($anotherFoo instanceof \_PhpScopera143bcca66cb\NegatedInstanceOf\Foo === \false) {
            return;
        }
        if ($fooAndBar instanceof \_PhpScopera143bcca66cb\NegatedInstanceOf\Foo && $fooAndBar instanceof \_PhpScopera143bcca66cb\NegatedInstanceOf\Bar) {
            die;
        }
    }
}
