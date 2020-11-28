<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05;

use PhpParser\Node\Identifier;
use PhpParser\Node\UnionType;
$unionedTypes = [new \PhpParser\Node\Identifier('string'), new \PhpParser\Node\Identifier('int')];
return new \PhpParser\Node\UnionType($unionedTypes);
