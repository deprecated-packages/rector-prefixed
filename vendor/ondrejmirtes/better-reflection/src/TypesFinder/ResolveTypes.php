<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Roave\BetterReflection\TypesFinder;

use _PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\Type;
use _PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\TypeResolver;
use _PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\Types\Context;
class ResolveTypes
{
    /** @var TypeResolver */
    private $typeResolver;
    public function __construct()
    {
        $this->typeResolver = new \_PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\TypeResolver();
    }
    /**
     * @param string[] $stringTypes
     *
     * @return Type[]
     */
    public function __invoke(array $stringTypes, \_PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\Types\Context $context) : array
    {
        $resolvedTypes = [];
        foreach ($stringTypes as $stringType) {
            $resolvedTypes[] = $this->typeResolver->resolve($stringType, $context);
        }
        return $resolvedTypes;
    }
}
