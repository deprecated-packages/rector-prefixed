<?php

namespace _PhpScoper88fe6e0ad041\Bug3947;

class HelloWorld
{
    public function sayHello(\SimpleXMLElement $item) : void
    {
        foreach ($item->items->children() as $groupItem) {
            switch ((string) $groupItem->orderType) {
            }
        }
    }
}
