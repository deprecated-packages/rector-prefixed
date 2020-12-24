<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\Contract;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\PropertyProperty;
interface RenamePropertyValueObjectInterface extends \_PhpScoperb75b35f52b74\Rector\Naming\Contract\RenameValueObjectInterface
{
    public function getClassLike() : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike;
    public function getClassLikeName() : string;
    public function getProperty() : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
    public function getPropertyProperty() : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\PropertyProperty;
}
