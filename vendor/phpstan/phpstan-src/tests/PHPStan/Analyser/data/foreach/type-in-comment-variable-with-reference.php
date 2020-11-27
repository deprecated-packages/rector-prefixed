<?php

namespace _PhpScoper26e51eeacccf\TypeInCommentOnForeach;

/** @var mixed[] $values */
$values = [];
/** @var string $value */
foreach ($values as &$value) {
    die;
}
