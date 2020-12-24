<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php71\Tests\Rector\FuncCall\RemoveExtraParametersRector\Source;

final class ChildOrmion extends \_PhpScopere8e811afab72\Rector\Php71\Tests\Rector\FuncCall\RemoveExtraParametersRector\Source\Ormion
{
    public static function getDb() : \_PhpScopere8e811afab72\Rector\Php71\Tests\Rector\FuncCall\RemoveExtraParametersRector\Source\Db
    {
        return new \_PhpScopere8e811afab72\Rector\Php71\Tests\Rector\FuncCall\RemoveExtraParametersRector\Source\Db();
    }
    /**
     * @return Db
     */
    public static function getDbWithAnnotationReturn()
    {
        return new \_PhpScopere8e811afab72\Rector\Php71\Tests\Rector\FuncCall\RemoveExtraParametersRector\Source\Db();
    }
}
