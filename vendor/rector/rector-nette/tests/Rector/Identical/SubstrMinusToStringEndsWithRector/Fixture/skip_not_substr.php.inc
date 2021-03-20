<?php

namespace Rector\Nette\Tests\Rector\Identical\SubstrMinusToStringEndsWithRector\Fixture;

function skipNotSustr($var)
{
    strlen($var) === 5;
}

?>
