<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\TypesFinder;

use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Type;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\TypeResolver;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Types\Context;
class ResolveTypes
{
    /** @var TypeResolver */
    private $typeResolver;
    public function __construct()
    {
        $this->typeResolver = new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\TypeResolver();
    }
    /**
     * @param string[] $stringTypes
     *
     * @return Type[]
     */
    public function __invoke(array $stringTypes, \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Types\Context $context) : array
    {
        $resolvedTypes = [];
        foreach ($stringTypes as $stringType) {
            $resolvedTypes[] = $this->typeResolver->resolve($stringType, $context);
        }
        return $resolvedTypes;
    }
}
