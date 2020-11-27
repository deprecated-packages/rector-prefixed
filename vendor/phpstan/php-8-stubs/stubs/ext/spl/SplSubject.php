<?php

namespace _PhpScoper006a73f0e455;

interface SplSubject
{
    /** @return void */
    public function attach(\SplObserver $observer);
    /** @return void */
    public function detach(\SplObserver $observer);
    /** @return void */
    public function notify();
}
\class_alias('_PhpScoper006a73f0e455\\SplSubject', 'SplSubject', \false);
