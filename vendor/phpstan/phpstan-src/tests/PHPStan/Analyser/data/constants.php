<?php

namespace _PhpScopera143bcca66cb\ConstantsForNodeScopeResolverTest;

$foo = FOO_CONSTANT;
\define('BAR_CONSTANT', 'bar');
if (\defined('BAZ_CONSTANT')) {
    die;
}
