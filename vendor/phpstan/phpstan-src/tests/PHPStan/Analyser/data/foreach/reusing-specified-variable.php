<?php

namespace _PhpScoper006a73f0e455\ReusingSpecifiedVariableInForeach;

/** @var string|null $business */
$business = doFoo();
if ($business !== null) {
    return;
}
foreach ([1, 2, 3] as $business) {
    die;
}
