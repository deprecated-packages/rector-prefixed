<?php

namespace _PhpScoperabd03f0baf05;

/** @var bool|null $boolOrNull */
$boolOrNull = \_PhpScoperabd03f0baf05\doFoo();
$bool = $boolOrNull !== null ? $boolOrNull : \false;
$short = $bool ?: null;
/** @var bool $a */
$a = \_PhpScoperabd03f0baf05\doBar();
/** @var bool $b */
$b = \_PhpScoperabd03f0baf05\doBaz();
$c = $a ?: $b;
/** @var string|null $qux */
$qux = \_PhpScoperabd03f0baf05\doQux();
$isQux = $qux !== null ?: $bool;
die;
