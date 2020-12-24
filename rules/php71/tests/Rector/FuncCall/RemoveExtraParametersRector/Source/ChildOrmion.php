<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php71\Tests\Rector\FuncCall\RemoveExtraParametersRector\Source;

final class ChildOrmion extends \_PhpScoper0a6b37af0871\Rector\Php71\Tests\Rector\FuncCall\RemoveExtraParametersRector\Source\Ormion
{
    public static function getDb() : \_PhpScoper0a6b37af0871\Rector\Php71\Tests\Rector\FuncCall\RemoveExtraParametersRector\Source\Db
    {
        return new \_PhpScoper0a6b37af0871\Rector\Php71\Tests\Rector\FuncCall\RemoveExtraParametersRector\Source\Db();
    }
    /**
     * @return Db
     */
    public static function getDbWithAnnotationReturn()
    {
        return new \_PhpScoper0a6b37af0871\Rector\Php71\Tests\Rector\FuncCall\RemoveExtraParametersRector\Source\Db();
    }
}
