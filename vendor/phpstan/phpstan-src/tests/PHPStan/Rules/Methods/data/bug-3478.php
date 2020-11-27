<?php

namespace _PhpScoper26e51eeacccf\Bug3478;

class ExtendedDocument extends \DOMDocument
{
    public function saveHTML(\DOMNode $node = null)
    {
        return parent::saveHTML($node);
    }
}
