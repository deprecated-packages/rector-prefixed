<?php

namespace _PhpScoper88fe6e0ad041\Bug3469;

abstract class Tile
{
    protected abstract function readSaveData() : void;
    protected abstract function writeSaveData() : void;
}
abstract class Spawnable extends \_PhpScoper88fe6e0ad041\Bug3469\Tile
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
class EnchantTable extends \_PhpScoper88fe6e0ad041\Bug3469\Spawnable
{
    use NameableTrait {
        loadName as readSaveData;
        saveName as writeSaveData;
    }
}
