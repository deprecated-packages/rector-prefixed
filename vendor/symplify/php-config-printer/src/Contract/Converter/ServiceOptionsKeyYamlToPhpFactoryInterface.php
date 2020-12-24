<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\Converter;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
interface ServiceOptionsKeyYamlToPhpFactoryInterface
{
    public function decorateServiceMethodCall($key, $yaml, $values, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $serviceMethodCall) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
    public function isMatch($key, $values) : bool;
}
