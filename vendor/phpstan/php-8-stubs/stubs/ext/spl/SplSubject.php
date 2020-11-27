<?php

namespace _PhpScoper26e51eeacccf;

interface SplSubject
{
    /** @return void */
    public function attach(\SplObserver $observer);
    /** @return void */
    public function detach(\SplObserver $observer);
    /** @return void */
    public function notify();
}
\class_alias('_PhpScoper26e51eeacccf\\SplSubject', 'SplSubject', \false);
