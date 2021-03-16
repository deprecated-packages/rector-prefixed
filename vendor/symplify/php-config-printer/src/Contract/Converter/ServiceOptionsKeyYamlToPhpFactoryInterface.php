<?php

declare (strict_types=1);
namespace RectorPrefix20210316\Symplify\PhpConfigPrinter\Contract\Converter;

use PhpParser\Node\Expr\MethodCall;
interface ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @param mixed $key
     * @param mixed $yaml
     * @param mixed $values
     */
    public function decorateServiceMethodCall($key, $yaml, $values, \PhpParser\Node\Expr\MethodCall $serviceMethodCall) : \PhpParser\Node\Expr\MethodCall;
    public function isMatch($key, $values) : bool;
}
