<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\ParamRenamer;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocManipulator\PropertyDocBlockManipulator;
use _PhpScopere8e811afab72\Rector\Naming\Contract\RenamerInterface;
use _PhpScopere8e811afab72\Rector\Naming\Contract\RenameValueObjectInterface;
use _PhpScopere8e811afab72\Rector\Naming\ValueObject\ParamRename;
use _PhpScopere8e811afab72\Rector\Naming\VariableRenamer;
final class ParamRenamer implements \_PhpScopere8e811afab72\Rector\Naming\Contract\RenamerInterface
{
    /**
     * @var VariableRenamer
     */
    private $variableRenamer;
    /**
     * @var PropertyDocBlockManipulator
     */
    private $propertyDocBlockManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\Naming\VariableRenamer $variableRenamer, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocManipulator\PropertyDocBlockManipulator $propertyDocBlockManipulator)
    {
        $this->variableRenamer = $variableRenamer;
        $this->propertyDocBlockManipulator = $propertyDocBlockManipulator;
    }
    /**
     * @param ParamRename $renameValueObject
     * @return Param
     */
    public function rename(\_PhpScopere8e811afab72\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : ?\_PhpScopere8e811afab72\PhpParser\Node
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
