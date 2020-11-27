<?php

namespace _PhpScoperbd5d0c5f7638\Bug3478;

class ExtendedDocument extends \DOMDocument
{
    public function saveHTML(\DOMNode $node = null)
    {
        return parent::saveHTML($node);
    }
}
