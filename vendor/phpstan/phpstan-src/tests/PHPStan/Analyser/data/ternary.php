<?php

namespace _PhpScoper88fe6e0ad041;

/** @var bool|null $boolOrNull */
$boolOrNull = \_PhpScoper88fe6e0ad041\doFoo();
$bool = $boolOrNull !== null ? $boolOrNull : \false;
$short = $bool ?: null;
/** @var bool $a */
$a = \_PhpScoper88fe6e0ad041\doBar();
/** @var bool $b */
$b = \_PhpScoper88fe6e0ad041\doBaz();
$c = $a ?: $b;
/** @var string|null $qux */
$qux = \_PhpScoper88fe6e0ad041\doQux();
$isQux = $qux !== null ?: $bool;
die;
