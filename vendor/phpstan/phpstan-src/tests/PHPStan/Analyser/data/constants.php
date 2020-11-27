<?php

namespace _PhpScoperbd5d0c5f7638\ConstantsForNodeScopeResolverTest;

$foo = FOO_CONSTANT;
\define('BAR_CONSTANT', 'bar');
if (\defined('BAZ_CONSTANT')) {
    die;
}
