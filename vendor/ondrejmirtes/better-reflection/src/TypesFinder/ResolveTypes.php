<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Roave\BetterReflection\TypesFinder;

use _PhpScoper006a73f0e455\phpDocumentor\Reflection\Type;
use _PhpScoper006a73f0e455\phpDocumentor\Reflection\TypeResolver;
use _PhpScoper006a73f0e455\phpDocumentor\Reflection\Types\Context;
class ResolveTypes
{
    /** @var TypeResolver */
    private $typeResolver;
    public function __construct()
    {
        $this->typeResolver = new \_PhpScoper006a73f0e455\phpDocumentor\Reflection\TypeResolver();
    }
    /**
     * @param string[] $stringTypes
     *
     * @return Type[]
     */
    public function __invoke(array $stringTypes, \_PhpScoper006a73f0e455\phpDocumentor\Reflection\Types\Context $context) : array
    {
        $resolvedTypes = [];
        foreach ($stringTypes as $stringType) {
            $resolvedTypes[] = $this->typeResolver->resolve($stringType, $context);
        }
        return $resolvedTypes;
    }
}
