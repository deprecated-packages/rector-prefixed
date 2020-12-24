<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Transform\Tests\Rector\FuncCall\FuncCallToMethodCallRector\Source;

abstract class TranslatorProvider
{
    private $translator;
    public function getTranslator() : \_PhpScoper0a6b37af0871\Rector\Transform\Tests\Rector\FuncCall\FuncCallToMethodCallRector\Source\SomeTranslator
    {
        return $this->translator;
    }
}
