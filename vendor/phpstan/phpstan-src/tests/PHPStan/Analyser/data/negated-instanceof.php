<?php

namespace _PhpScoperabd03f0baf05\NegatedInstanceOf;

class Foo
{
    public function someMethod($foo, $bar, $otherBar, $lorem, $otherLorem, $dolor, $sit, $mixedFoo, $mixedBar, $self, $static, $anotherFoo, $fooAndBar)
    {
        if (!$foo instanceof \_PhpScoperabd03f0baf05\NegatedInstanceOf\Foo) {
            return;
        }
        if (!$bar instanceof \_PhpScoperabd03f0baf05\NegatedInstanceOf\Bar || \get_class($bar) !== \get_class($otherBar)) {
            return;
        }
        if (!($lorem instanceof \_PhpScoperabd03f0baf05\NegatedInstanceOf\Lorem || \get_class($lorem) === \get_class($otherLorem))) {
            // still mixed after if
            return;
        }
        if ($dolor instanceof \_PhpScoperabd03f0baf05\NegatedInstanceOf\Dolor) {
            // still mixed after if
            return;
        }
        if (!!$sit instanceof \_PhpScoperabd03f0baf05\NegatedInstanceOf\Sit) {
            // still mixed after if
            return;
        }
        if ($mixedFoo instanceof \_PhpScoperabd03f0baf05\NegatedInstanceOf\Foo && doFoo()) {
            return;
        }
        if (!$mixedBar instanceof \_PhpScoperabd03f0baf05\NegatedInstanceOf\Bar && doFoo()) {
            return;
        }
        if (!$self instanceof self) {
            return;
        }
        if (!$static instanceof static) {
            return;
        }
        if ($anotherFoo instanceof \_PhpScoperabd03f0baf05\NegatedInstanceOf\Foo === \false) {
            return;
        }
        if ($fooAndBar instanceof \_PhpScoperabd03f0baf05\NegatedInstanceOf\Foo && $fooAndBar instanceof \_PhpScoperabd03f0baf05\NegatedInstanceOf\Bar) {
            die;
        }
    }
}
