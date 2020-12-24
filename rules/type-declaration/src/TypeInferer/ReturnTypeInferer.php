<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer;

use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeNormalizer;
use _PhpScoperb75b35f52b74\Webmozart\Assert\Assert;
final class ReturnTypeInferer extends \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\AbstractPriorityAwareTypeInferer
{
    /**
     * @var ReturnTypeInfererInterface[]
     */
    private $returnTypeInferers = [];
    /**
     * @var TypeNormalizer
     */
    private $typeNormalizer;
    /**
     * @param ReturnTypeInfererInterface[] $returnTypeInferers
     */
    public function __construct(array $returnTypeInferers, \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeNormalizer $typeNormalizer)
    {
        $this->returnTypeInferers = $this->sortTypeInferersByPriority($returnTypeInferers);
        $this->typeNormalizer = $typeNormalizer;
    }
    public function inferFunctionLike(\_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->inferFunctionLikeWithExcludedInferers($functionLike, []);
    }
    /**
     * @param string[] $excludedInferers
     */
    public function inferFunctionLikeWithExcludedInferers(\_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike, array $excludedInferers) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        foreach ($this->returnTypeInferers as $returnTypeInferer) {
            if ($this->shouldSkipExcludedTypeInferer($returnTypeInferer, $excludedInferers)) {
                continue;
            }
            $originalType = $returnTypeInferer->inferFunctionLike($functionLike);
            if ($originalType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
                continue;
            }
            $type = $this->typeNormalizer->normalizeArrayTypeAndArrayNever($originalType);
            $type = $this->typeNormalizer->uniqueateConstantArrayType($type);
            // in case of void, check return type of children methods
            if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
                continue;
            }
            return $type;
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
    }
    /**
     * @param string[] $excludedInferers
     */
    private function shouldSkipExcludedTypeInferer(\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface $returnTypeInferer, array $excludedInferers) : bool
    {
        \_PhpScoperb75b35f52b74\Webmozart\Assert\Assert::allIsAOf($excludedInferers, \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface::class);
        foreach ($excludedInferers as $excludedInferer) {
            if (\is_a($returnTypeInferer, $excludedInferer)) {
                return \true;
            }
        }
        return \false;
    }
}
