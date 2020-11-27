<?php

namespace _PhpScoperbd5d0c5f7638\Bug3469;

abstract class Tile
{
    protected abstract function readSaveData() : void;
    protected abstract function writeSaveData() : void;
}
abstract class Spawnable extends \_PhpScoperbd5d0c5f7638\Bug3469\Tile
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
class EnchantTable extends \_PhpScoperbd5d0c5f7638\Bug3469\Spawnable
{
    use NameableTrait {
        loadName as readSaveData;
        saveName as writeSaveData;
    }
}
