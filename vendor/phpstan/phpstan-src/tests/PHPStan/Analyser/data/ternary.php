<?php

namespace _PhpScoper006a73f0e455;

/** @var bool|null $boolOrNull */
$boolOrNull = \_PhpScoper006a73f0e455\doFoo();
$bool = $boolOrNull !== null ? $boolOrNull : \false;
$short = $bool ?: null;
/** @var bool $a */
$a = \_PhpScoper006a73f0e455\doBar();
/** @var bool $b */
$b = \_PhpScoper006a73f0e455\doBaz();
$c = $a ?: $b;
/** @var string|null $qux */
$qux = \_PhpScoper006a73f0e455\doQux();
$isQux = $qux !== null ?: $bool;
die;
