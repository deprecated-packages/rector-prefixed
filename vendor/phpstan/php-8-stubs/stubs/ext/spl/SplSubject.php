<?php

namespace _PhpScoperabd03f0baf05;

interface SplSubject
{
    /** @return void */
    public function attach(\SplObserver $observer);
    /** @return void */
    public function detach(\SplObserver $observer);
    /** @return void */
    public function notify();
}
\class_alias('_PhpScoperabd03f0baf05\\SplSubject', 'SplSubject', \false);
