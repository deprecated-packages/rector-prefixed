<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Naming\Contract;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\PropertyProperty;
interface RenamePropertyValueObjectInterface extends \_PhpScoper0a2ac50786fa\Rector\Naming\Contract\RenameValueObjectInterface
{
    public function getClassLike() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike;
    public function getClassLikeName() : string;
    public function getProperty() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property;
    public function getPropertyProperty() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\PropertyProperty;
}
