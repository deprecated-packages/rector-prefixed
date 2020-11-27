<?php

namespace _PhpScoper88fe6e0ad041\Bug3478;

class ExtendedDocument extends \DOMDocument
{
    public function saveHTML(\DOMNode $node = null)
    {
        return parent::saveHTML($node);
    }
}
