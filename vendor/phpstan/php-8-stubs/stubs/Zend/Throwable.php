<?php

namespace _PhpScopera143bcca66cb;

/** @generate-function-entries */
interface Throwable extends \Stringable
{
    public function getMessage() : string;
    public function getCode();
    public function getFile() : string;
    public function getLine() : int;
    public function getTrace() : array;
    public function getPrevious() : ?\Throwable;
    public function getTraceAsString() : string;
}
/** @generate-function-entries */
\class_alias('_PhpScopera143bcca66cb\\Throwable', 'Throwable', \false);
