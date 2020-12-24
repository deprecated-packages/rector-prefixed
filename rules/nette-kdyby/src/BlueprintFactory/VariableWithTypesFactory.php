<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NetteKdyby\BlueprintFactory;

use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StaticType;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\NetteKdyby\Naming\VariableNaming;
use _PhpScoper0a6b37af0871\Rector\NetteKdyby\ValueObject\VariableWithType;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\StaticTypeMapper;
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \_PhpScoper0a6b37af0871\Rector\NetteKdyby\Naming\VariableNaming $variableNaming)
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
                throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
            }
            // compensate for static
            if ($staticType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\StaticType) {
                $staticType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($staticType->getClassName());
            }
            $phpParserTypeNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($staticType);
            $variablesWithTypes[] = new \_PhpScoper0a6b37af0871\Rector\NetteKdyby\ValueObject\VariableWithType($variableName, $staticType, $phpParserTypeNode);
        }
        return $variablesWithTypes;
    }
}
