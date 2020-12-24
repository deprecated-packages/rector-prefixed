<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Exception\NotImplementedYetException;
final class SharedPublicServiceOptionKeyYamlToPhpFactory implements \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    public function decorateServiceMethodCall($key, $yaml, $values, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall
    {
        if ($key === 'public') {
            if ($yaml === \false) {
                return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($methodCall, 'private');
            }
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($methodCall, 'public');
        }
        throw new \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Exception\NotImplementedYetException();
    }
    public function isMatch($key, $values) : bool
    {
        return \in_array($key, ['shared', 'public'], \true);
    }
}
