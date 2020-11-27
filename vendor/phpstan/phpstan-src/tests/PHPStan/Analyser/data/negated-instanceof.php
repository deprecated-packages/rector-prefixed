<?php

namespace _PhpScoper88fe6e0ad041\NegatedInstanceOf;

class Foo
{
    public function someMethod($foo, $bar, $otherBar, $lorem, $otherLorem, $dolor, $sit, $mixedFoo, $mixedBar, $self, $static, $anotherFoo, $fooAndBar)
    {
        if (!$foo instanceof \_PhpScoper88fe6e0ad041\NegatedInstanceOf\Foo) {
            return;
        }
        if (!$bar instanceof \_PhpScoper88fe6e0ad041\NegatedInstanceOf\Bar || \get_class($bar) !== \get_class($otherBar)) {
            return;
        }
        if (!($lorem instanceof \_PhpScoper88fe6e0ad041\NegatedInstanceOf\Lorem || \get_class($lorem) === \get_class($otherLorem))) {
            // still mixed after if
            return;
        }
        if ($dolor instanceof \_PhpScoper88fe6e0ad041\NegatedInstanceOf\Dolor) {
            // still mixed after if
            return;
        }
        if (!!$sit instanceof \_PhpScoper88fe6e0ad041\NegatedInstanceOf\Sit) {
            // still mixed after if
            return;
        }
        if ($mixedFoo instanceof \_PhpScoper88fe6e0ad041\NegatedInstanceOf\Foo && doFoo()) {
            return;
        }
        if (!$mixedBar instanceof \_PhpScoper88fe6e0ad041\NegatedInstanceOf\Bar && doFoo()) {
            return;
        }
        if (!$self instanceof self) {
            return;
        }
        if (!$static instanceof static) {
            return;
        }
        if ($anotherFoo instanceof \_PhpScoper88fe6e0ad041\NegatedInstanceOf\Foo === \false) {
            return;
        }
        if ($fooAndBar instanceof \_PhpScoper88fe6e0ad041\NegatedInstanceOf\Foo && $fooAndBar instanceof \_PhpScoper88fe6e0ad041\NegatedInstanceOf\Bar) {
            die;
        }
    }
}
