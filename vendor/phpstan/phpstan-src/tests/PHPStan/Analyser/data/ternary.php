<?php

namespace _PhpScopera143bcca66cb;

/** @var bool|null $boolOrNull */
$boolOrNull = \_PhpScopera143bcca66cb\doFoo();
$bool = $boolOrNull !== null ? $boolOrNull : \false;
$short = $bool ?: null;
/** @var bool $a */
$a = \_PhpScopera143bcca66cb\doBar();
/** @var bool $b */
$b = \_PhpScopera143bcca66cb\doBaz();
$c = $a ?: $b;
/** @var string|null $qux */
$qux = \_PhpScopera143bcca66cb\doQux();
$isQux = $qux !== null ?: $bool;
die;
