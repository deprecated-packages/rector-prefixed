<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\Contract\Converter;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
interface ServiceOptionsKeyYamlToPhpFactoryInterface
{
    public function decorateServiceMethodCall($key, $yaml, $values, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $serviceMethodCall) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
    public function isMatch($key, $values) : bool;
}
