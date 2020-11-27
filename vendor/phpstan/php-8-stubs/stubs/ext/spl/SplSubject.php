<?php

namespace _PhpScoperbd5d0c5f7638;

interface SplSubject
{
    /** @return void */
    public function attach(\SplObserver $observer);
    /** @return void */
    public function detach(\SplObserver $observer);
    /** @return void */
    public function notify();
}
\class_alias('_PhpScoperbd5d0c5f7638\\SplSubject', 'SplSubject', \false);
