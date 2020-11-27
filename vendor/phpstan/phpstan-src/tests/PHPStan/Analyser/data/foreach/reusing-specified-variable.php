<?php

namespace _PhpScoper26e51eeacccf\ReusingSpecifiedVariableInForeach;

/** @var string|null $business */
$business = doFoo();
if ($business !== null) {
    return;
}
foreach ([1, 2, 3] as $business) {
    die;
}
