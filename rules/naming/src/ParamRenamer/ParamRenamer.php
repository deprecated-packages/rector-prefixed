<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Naming\ParamRenamer;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocManipulator\PropertyDocBlockManipulator;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract\RenamerInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract\RenameValueObjectInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\ValueObject\ParamRename;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\VariableRenamer;
final class ParamRenamer implements \_PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract\RenamerInterface
{
    /**
     * @var VariableRenamer
     */
    private $variableRenamer;
    /**
     * @var PropertyDocBlockManipulator
     */
    private $propertyDocBlockManipulator;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\VariableRenamer $variableRenamer, \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocManipulator\PropertyDocBlockManipulator $propertyDocBlockManipulator)
    {
        $this->variableRenamer = $variableRenamer;
        $this->propertyDocBlockManipulator = $propertyDocBlockManipulator;
    }
    /**
     * @param ParamRename $renameValueObject
     * @return Param
     */
    public function rename(\_PhpScoper2a4e7ab1ecbc\Rector\Naming\Contract\RenameValueObjectInterface $renameValueObject) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
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
