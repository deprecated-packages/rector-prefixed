<?php

namespace _PhpScoperabd03f0baf05\Bug3478;

class ExtendedDocument extends \DOMDocument
{
    public function saveHTML(\DOMNode $node = null)
    {
        return parent::saveHTML($node);
    }
}
