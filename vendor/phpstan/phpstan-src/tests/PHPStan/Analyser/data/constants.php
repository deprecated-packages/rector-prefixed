<?php

namespace _PhpScoper006a73f0e455\ConstantsForNodeScopeResolverTest;

$foo = FOO_CONSTANT;
\define('BAR_CONSTANT', 'bar');
if (\defined('BAZ_CONSTANT')) {
    die;
}
