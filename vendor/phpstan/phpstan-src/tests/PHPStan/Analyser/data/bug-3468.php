<?php

namespace _PhpScoper26e51eeacccf\Bug3468;

class NewInterval extends \DateInterval
{
}
function (\_PhpScoper26e51eeacccf\Bug3468\NewInterval $ni) : void {
    $ni->f = 0.1;
};
class NewDocument extends \DOMDocument
{
}
function (\_PhpScoper26e51eeacccf\Bug3468\NewDocument $nd) : void {
    $element = $nd->documentElement;
};
