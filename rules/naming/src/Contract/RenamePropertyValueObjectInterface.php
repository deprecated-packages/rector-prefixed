<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\PropertyProperty;
interface RenamePropertyValueObjectInterface extends \_PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract\RenameValueObjectInterface
{
    public function getClassLike() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassLike;
    public function getClassLikeName() : string;
    public function getProperty() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property;
    public function getPropertyProperty() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\PropertyProperty;
}
