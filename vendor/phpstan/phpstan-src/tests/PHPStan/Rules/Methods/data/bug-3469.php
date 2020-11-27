<?php

namespace _PhpScopera143bcca66cb\Bug3469;

abstract class Tile
{
    protected abstract function readSaveData() : void;
    protected abstract function writeSaveData() : void;
}
abstract class Spawnable extends \_PhpScopera143bcca66cb\Bug3469\Tile
{
}
trait NameableTrait
{
    protected function loadName() : void
    {
    }
    protected function saveName() : void
    {
    }
}
class EnchantTable extends \_PhpScopera143bcca66cb\Bug3469\Spawnable
{
    use NameableTrait {
        loadName as readSaveData;
        saveName as writeSaveData;
    }
}
