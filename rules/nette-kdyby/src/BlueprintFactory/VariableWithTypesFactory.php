<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteKdyby\BlueprintFactory;

use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\StaticType;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\NetteKdyby\Naming\VariableNaming;
use _PhpScopere8e811afab72\Rector\NetteKdyby\ValueObject\VariableWithType;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper;
final class VariableWithTypesFactory
{
    /**
     * @var VariableNaming
     */
    private $variableNaming;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \_PhpScopere8e811afab72\Rector\NetteKdyby\Naming\VariableNaming $variableNaming)
    {
        $this->variableNaming = $variableNaming;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->staticTypeMapper = $staticTypeMapper;
    }
    /**
     * @param Arg[] $args
     * @return VariableWithType[]
     */
    public function createVariablesWithTypesFromArgs(array $args) : array
    {
        $variablesWithTypes = [];
        foreach ($args as $arg) {
            $staticType = $this->nodeTypeResolver->getStaticType($arg->value);
            $variableName = $this->variableNaming->resolveFromNodeAndType($arg, $staticType);
            if ($variableName === null) {
                throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
            }
            // compensate for static
            if ($staticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\StaticType) {
                $staticType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($staticType->getClassName());
            }
            $phpParserTypeNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($staticType);
            $variablesWithTypes[] = new \_PhpScopere8e811afab72\Rector\NetteKdyby\ValueObject\VariableWithType($variableName, $staticType, $phpParserTypeNode);
        }
        return $variablesWithTypes;
    }
}
