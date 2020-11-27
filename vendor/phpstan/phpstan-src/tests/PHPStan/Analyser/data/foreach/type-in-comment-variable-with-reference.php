<?php

namespace _PhpScopera143bcca66cb\TypeInCommentOnForeach;

/** @var mixed[] $values */
$values = [];
/** @var string $value */
foreach ($values as &$value) {
    die;
}
