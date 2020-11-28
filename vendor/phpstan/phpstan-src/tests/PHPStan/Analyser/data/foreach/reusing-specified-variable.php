<?php

namespace _PhpScoperabd03f0baf05\ReusingSpecifiedVariableInForeach;

/** @var string|null $business */
$business = doFoo();
if ($business !== null) {
    return;
}
foreach ([1, 2, 3] as $business) {
    die;
}
