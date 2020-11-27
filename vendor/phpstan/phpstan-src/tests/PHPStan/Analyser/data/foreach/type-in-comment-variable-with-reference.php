<?php

namespace _PhpScoper006a73f0e455\TypeInCommentOnForeach;

/** @var mixed[] $values */
$values = [];
/** @var string $value */
foreach ($values as &$value) {
    die;
}
