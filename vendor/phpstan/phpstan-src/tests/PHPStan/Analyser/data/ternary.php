<?php

namespace _PhpScoperbd5d0c5f7638;

/** @var bool|null $boolOrNull */
$boolOrNull = \_PhpScoperbd5d0c5f7638\doFoo();
$bool = $boolOrNull !== null ? $boolOrNull : \false;
$short = $bool ?: null;
/** @var bool $a */
$a = \_PhpScoperbd5d0c5f7638\doBar();
/** @var bool $b */
$b = \_PhpScoperbd5d0c5f7638\doBaz();
$c = $a ?: $b;
/** @var string|null $qux */
$qux = \_PhpScoperbd5d0c5f7638\doQux();
$isQux = $qux !== null ?: $bool;
die;
