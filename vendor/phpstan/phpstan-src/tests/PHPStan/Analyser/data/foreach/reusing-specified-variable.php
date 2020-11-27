<?php

namespace _PhpScoperbd5d0c5f7638\ReusingSpecifiedVariableInForeach;

/** @var string|null $business */
$business = doFoo();
if ($business !== null) {
    return;
}
foreach ([1, 2, 3] as $business) {
    die;
}
