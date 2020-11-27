<?php

namespace _PhpScoper26e51eeacccf;

/** @var bool|null $boolOrNull */
$boolOrNull = \_PhpScoper26e51eeacccf\doFoo();
$bool = $boolOrNull !== null ? $boolOrNull : \false;
$short = $bool ?: null;
/** @var bool $a */
$a = \_PhpScoper26e51eeacccf\doBar();
/** @var bool $b */
$b = \_PhpScoper26e51eeacccf\doBaz();
$c = $a ?: $b;
/** @var string|null $qux */
$qux = \_PhpScoper26e51eeacccf\doQux();
$isQux = $qux !== null ?: $bool;
die;
