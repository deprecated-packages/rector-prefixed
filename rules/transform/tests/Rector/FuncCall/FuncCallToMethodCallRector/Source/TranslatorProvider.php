<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Transform\Tests\Rector\FuncCall\FuncCallToMethodCallRector\Source;

abstract class TranslatorProvider
{
    private $translator;
    public function getTranslator() : \_PhpScoperb75b35f52b74\Rector\Transform\Tests\Rector\FuncCall\FuncCallToMethodCallRector\Source\SomeTranslator
    {
        return $this->translator;
    }
}
