<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Transform\Tests\Rector\FuncCall\FuncCallToMethodCallRector\Source;

abstract class NullableTranslatorProvider
{
    private $translator;
    public function getTranslator() : ?\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Tests\Rector\FuncCall\FuncCallToMethodCallRector\Source\SomeTranslator
    {
        return $this->translator;
    }
}
