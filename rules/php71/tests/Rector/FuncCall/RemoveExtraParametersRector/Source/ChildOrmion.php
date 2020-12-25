<?php

declare (strict_types=1);
namespace Rector\Php71\Tests\Rector\FuncCall\RemoveExtraParametersRector\Source;

final class ChildOrmion extends \Rector\Php71\Tests\Rector\FuncCall\RemoveExtraParametersRector\Source\Ormion
{
    public static function getDb() : \Rector\Php71\Tests\Rector\FuncCall\RemoveExtraParametersRector\Source\Db
    {
        return new \Rector\Php71\Tests\Rector\FuncCall\RemoveExtraParametersRector\Source\Db();
    }
    /**
     * @return Db
     */
    public static function getDbWithAnnotationReturn()
    {
        return new \Rector\Php71\Tests\Rector\FuncCall\RemoveExtraParametersRector\Source\Db();
    }
}
