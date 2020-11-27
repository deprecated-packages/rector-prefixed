<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\ThrowsPhpDocs;

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
