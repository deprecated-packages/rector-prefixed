<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf;

use PhpParser\Node\Identifier;
use PhpParser\Node\UnionType;
$unionedTypes = [new \PhpParser\Node\Identifier('string'), new \PhpParser\Node\Identifier('int')];
return new \PhpParser\Node\UnionType($unionedTypes);
