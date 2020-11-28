<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\ThrowsPhpDocs;

use LogicException;
use RuntimeException;
interface Foo
{
    /**
     * @throws RuntimeException
     */
    public function throwRuntimeException();
    /**
     * @throws RuntimeException|LogicException
     */
    public function throwRuntimeAndLogicException();
    /**
     * @throws RuntimeException
     * @throws LogicException
     */
    public function throwRuntimeAndLogicException2();
}
