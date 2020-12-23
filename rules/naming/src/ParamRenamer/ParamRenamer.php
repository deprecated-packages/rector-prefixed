<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Naming\ParamRenamer;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Param;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocManipulator\PropertyDocBlockManipulator;
use _PhpScoper0a2ac50786fa\Rector\Naming\Contract\RenamerInterface;
use _PhpScoper0a2ac50786fa\Rector\Naming\Contract\RenameValueObjectInterface;
use _PhpScoper0a2ac50786fa\Rector\Naming\ValueObject\ParamRename;
use _PhpScoper0a2ac50786fa\Rector\Naming\VariableRenamer;
final class ParamRenamer implements \_PhpScoper0a2ac50786fa\Rector\Naming\Contract\RenamerInterface
{
    /**
     * @var VariableRenamer
     */
    private $variableRenamer;
    /**
     * @var PropertyDocBlockManipulator
     */
    private $propertyDocBlockManipulator;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Naming\VariableRenamer $variableRenamer, \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocManipulator\PropertyDocBlockManipulator $propertyDocBlockManipulator)
    {
        $this->variableRenamer = $variableRenamer;
        $this->propertyDocBlockManipulator = $propertyDocBlockManipulator;
    }
    /**
     * @param ParamRename $renameValueObject
     * @return Param
     */
    public function rename(\_PhpScoper0a2ac50786fa\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
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
