<?php

namespace _PhpScoper006a73f0e455\Bug3478;

class ExtendedDocument extends \DOMDocument
{
    public function saveHTML(\DOMNode $node = null)
    {
        return parent::saveHTML($node);
    }
}
