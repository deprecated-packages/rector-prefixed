<?php

namespace _PhpScoper88fe6e0ad041;

interface SplSubject
{
    /** @return void */
    public function attach(\SplObserver $observer);
    /** @return void */
    public function detach(\SplObserver $observer);
    /** @return void */
    public function notify();
}
\class_alias('_PhpScoper88fe6e0ad041\\SplSubject', 'SplSubject', \false);
