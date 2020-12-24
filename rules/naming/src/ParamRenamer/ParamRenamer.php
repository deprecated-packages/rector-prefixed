<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\ParamRenamer;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocManipulator\PropertyDocBlockManipulator;
use _PhpScoperb75b35f52b74\Rector\Naming\Contract\RenamerInterface;
use _PhpScoperb75b35f52b74\Rector\Naming\Contract\RenameValueObjectInterface;
use _PhpScoperb75b35f52b74\Rector\Naming\ValueObject\ParamRename;
use _PhpScoperb75b35f52b74\Rector\Naming\VariableRenamer;
final class ParamRenamer implements \_PhpScoperb75b35f52b74\Rector\Naming\Contract\RenamerInterface
{
    /**
     * @var VariableRenamer
     */
    private $variableRenamer;
    /**
     * @var PropertyDocBlockManipulator
     */
    private $propertyDocBlockManipulator;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Naming\VariableRenamer $variableRenamer, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocManipulator\PropertyDocBlockManipulator $propertyDocBlockManipulator)
    {
        $this->variableRenamer = $variableRenamer;
        $this->propertyDocBlockManipulator = $propertyDocBlockManipulator;
    }
    /**
     * @param ParamRename $renameValueObject
     * @return Param
     */
    public function rename(\_PhpScoperb75b35f52b74\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        // 1. rename param
        $renameValueObject->getVariable()->name = $renameValueObject->getExpectedName();
        // 2. rename param in the rest of the method
        $this->variableRenamer->renameVariableInFunctionLike($renameValueObject->getFunctionLike(), null, $renameValueObject->getCurrentName(), $renameValueObject->getExpectedName());
        // 3. rename @param variable in docblock too
        $this->propertyDocBlockManipulator->renameParameterNameInDocBlock($renameValueObject);
        return $renameValueObject->getParam();
    }
}
