<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\Contract\Converter;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
interface ServiceOptionsKeyYamlToPhpFactoryInterface
{
    public function decorateServiceMethodCall($key, $yaml, $values, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $serviceMethodCall) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
    public function isMatch($key, $values) : bool;
}
