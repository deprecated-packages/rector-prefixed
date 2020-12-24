<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\Contract\Converter;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
interface ServiceOptionsKeyYamlToPhpFactoryInterface
{
    public function decorateServiceMethodCall($key, $yaml, $values, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $serviceMethodCall) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
    public function isMatch($key, $values) : bool;
}
