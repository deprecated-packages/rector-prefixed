<?php

namespace _PhpScoperbd5d0c5f7638\NegatedInstanceOf;

class Foo
{
    public function someMethod($foo, $bar, $otherBar, $lorem, $otherLorem, $dolor, $sit, $mixedFoo, $mixedBar, $self, $static, $anotherFoo, $fooAndBar)
    {
        if (!$foo instanceof \_PhpScoperbd5d0c5f7638\NegatedInstanceOf\Foo) {
            return;
        }
        if (!$bar instanceof \_PhpScoperbd5d0c5f7638\NegatedInstanceOf\Bar || \get_class($bar) !== \get_class($otherBar)) {
            return;
        }
        if (!($lorem instanceof \_PhpScoperbd5d0c5f7638\NegatedInstanceOf\Lorem || \get_class($lorem) === \get_class($otherLorem))) {
            // still mixed after if
            return;
        }
        if ($dolor instanceof \_PhpScoperbd5d0c5f7638\NegatedInstanceOf\Dolor) {
            // still mixed after if
            return;
        }
        if (!!$sit instanceof \_PhpScoperbd5d0c5f7638\NegatedInstanceOf\Sit) {
            // still mixed after if
            return;
        }
        if ($mixedFoo instanceof \_PhpScoperbd5d0c5f7638\NegatedInstanceOf\Foo && doFoo()) {
            return;
        }
        if (!$mixedBar instanceof \_PhpScoperbd5d0c5f7638\NegatedInstanceOf\Bar && doFoo()) {
            return;
        }
        if (!$self instanceof self) {
            return;
        }
        if (!$static instanceof static) {
            return;
        }
        if ($anotherFoo instanceof \_PhpScoperbd5d0c5f7638\NegatedInstanceOf\Foo === \false) {
            return;
        }
        if ($fooAndBar instanceof \_PhpScoperbd5d0c5f7638\NegatedInstanceOf\Foo && $fooAndBar instanceof \_PhpScoperbd5d0c5f7638\NegatedInstanceOf\Bar) {
            die;
        }
    }
}
