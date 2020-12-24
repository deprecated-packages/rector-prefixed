<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php71\Tests\Rector\FuncCall\RemoveExtraParametersRector\Source;

final class ChildOrmion extends \_PhpScoperb75b35f52b74\Rector\Php71\Tests\Rector\FuncCall\RemoveExtraParametersRector\Source\Ormion
{
    public static function getDb() : \_PhpScoperb75b35f52b74\Rector\Php71\Tests\Rector\FuncCall\RemoveExtraParametersRector\Source\Db
    {
        return new \_PhpScoperb75b35f52b74\Rector\Php71\Tests\Rector\FuncCall\RemoveExtraParametersRector\Source\Db();
    }
    /**
     * @return Db
     */
    public static function getDbWithAnnotationReturn()
    {
        return new \_PhpScoperb75b35f52b74\Rector\Php71\Tests\Rector\FuncCall\RemoveExtraParametersRector\Source\Db();
    }
}
