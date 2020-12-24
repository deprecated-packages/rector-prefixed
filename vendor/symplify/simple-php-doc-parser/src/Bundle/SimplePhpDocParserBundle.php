<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\SimplePhpDocParser\Bundle;

use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScopere8e811afab72\Symfony\Component\HttpKernel\Bundle\Bundle;
use _PhpScopere8e811afab72\Symplify\SimplePhpDocParser\Bundle\DependencyInjection\Extension\SimplePhpDocParserExtension;
final class SimplePhpDocParserBundle extends \_PhpScopere8e811afab72\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function getContainerExtension() : ?\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \_PhpScopere8e811afab72\Symplify\SimplePhpDocParser\Bundle\DependencyInjection\Extension\SimplePhpDocParserExtension();
    }
}
