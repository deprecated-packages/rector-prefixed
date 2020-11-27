<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041;

use PhpParser\Node\Identifier;
use PhpParser\Node\UnionType;
$unionedTypes = [new \PhpParser\Node\Identifier('string'), new \PhpParser\Node\Identifier('int')];
return new \PhpParser\Node\UnionType($unionedTypes);
