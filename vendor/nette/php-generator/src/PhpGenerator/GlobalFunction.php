<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Nette\PhpGenerator;

use _PhpScoperabd03f0baf05\Nette;
/**
 * Global function.
 *
 * @property string $body
 */
final class GlobalFunction
{
    use Nette\SmartObject;
    use Traits\FunctionLike;
    use Traits\NameAware;
    use Traits\CommentAware;
    use Traits\AttributeAware;
    public static function from(string $function) : self
    {
        return (new \_PhpScoperabd03f0baf05\Nette\PhpGenerator\Factory())->fromFunctionReflection(new \ReflectionFunction($function));
    }
    public static function withBodyFrom(string $function) : self
    {
        return (new \_PhpScoperabd03f0baf05\Nette\PhpGenerator\Factory())->fromFunctionReflection(new \ReflectionFunction($function), \true);
    }
    public function __toString() : string
    {
        try {
            return (new \_PhpScoperabd03f0baf05\Nette\PhpGenerator\Printer())->printFunction($this);
        } catch (\Throwable $e) {
            if (\PHP_VERSION_ID >= 70400) {
                throw $e;
            }
            \trigger_error('Exception in ' . __METHOD__ . "(): {$e->getMessage()} in {$e->getFile()}:{$e->getLine()}", \E_USER_ERROR);
            return '';
        }
    }
}
