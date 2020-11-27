<?php

namespace _PhpScopera143bcca66cb;

interface SplSubject
{
    /** @return void */
    public function attach(\SplObserver $observer);
    /** @return void */
    public function detach(\SplObserver $observer);
    /** @return void */
    public function notify();
}
\class_alias('_PhpScopera143bcca66cb\\SplSubject', 'SplSubject', \false);
