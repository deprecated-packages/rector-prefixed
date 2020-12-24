<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\Contract;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\PropertyProperty;
interface RenamePropertyValueObjectInterface extends \_PhpScoper0a6b37af0871\Rector\Naming\Contract\RenameValueObjectInterface
{
    public function getClassLike() : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike;
    public function getClassLikeName() : string;
    public function getProperty() : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
    public function getPropertyProperty() : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\PropertyProperty;
}
