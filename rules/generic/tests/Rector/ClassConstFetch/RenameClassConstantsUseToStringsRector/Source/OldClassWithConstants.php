<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\Tests\Rector\ClassConstFetch\RenameClassConstantsUseToStringsRector\Source;

final class OldClassWithConstants
{
    /**
     * @var string
     */
    public const DEVELOPMENT = 'development';
    /**
     * @var string
     */
    public const PRODUCTION = 'production';
}
