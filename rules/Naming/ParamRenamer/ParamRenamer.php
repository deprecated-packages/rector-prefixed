<?php

declare(strict_types=1);

namespace Rector\Naming\ParamRenamer;

use PhpParser\Node\Param;
use Rector\BetterPhpDocParser\PhpDocManipulator\PropertyDocBlockManipulator;
use Rector\Naming\ValueObject\ParamRename;
use Rector\Naming\VariableRenamer;

final class ParamRenamer
{
    /**
     * @var VariableRenamer
     */
    private $variableRenamer;

    /**
     * @var PropertyDocBlockManipulator
     */
    private $propertyDocBlockManipulator;

    public function __construct(
        VariableRenamer $variableRenamer,
        PropertyDocBlockManipulator $propertyDocBlockManipulator
    ) {
        $this->variableRenamer = $variableRenamer;
        $this->propertyDocBlockManipulator = $propertyDocBlockManipulator;
    }

    /**
     * @return void
     */
    public function rename(ParamRename $paramRename)
    {
        // 1. rename param
        $paramRename->getVariable()
            ->name = $paramRename->getExpectedName();

        // 2. rename param in the rest of the method
        $this->variableRenamer->renameVariableInFunctionLike(
            $paramRename->getFunctionLike(),
            null,
            $paramRename->getCurrentName(),
            $paramRename->getExpectedName()
        );

        // 3. rename @param variable in docblock too
        $this->propertyDocBlockManipulator->renameParameterNameInDocBlock($paramRename);
    }
}
