<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Transform\Tests\Rector\FuncCall\FuncCallToMethodCallRector\Source;

abstract class NullableTranslatorProvider
{
    private $translator;
    public function getTranslator() : ?\_PhpScopere8e811afab72\Rector\Transform\Tests\Rector\FuncCall\FuncCallToMethodCallRector\Source\SomeTranslator
    {
        return $this->translator;
    }
}
