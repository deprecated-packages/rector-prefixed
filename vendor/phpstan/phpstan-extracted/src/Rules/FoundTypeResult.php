<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
class FoundTypeResult
{
    /** @var \PHPStan\Type\Type */
    private $type;
    /** @var string[] */
    private $referencedClasses;
    /** @var RuleError[] */
    private $unknownClassErrors;
    /**
     * @param \PHPStan\Type\Type $type
     * @param string[] $referencedClasses
     * @param RuleError[] $unknownClassErrors
     */
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, array $referencedClasses, array $unknownClassErrors)
    {
        $this->type = $type;
        $this->referencedClasses = $referencedClasses;
        $this->unknownClassErrors = $unknownClassErrors;
    }
    public function getType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this->type;
    }
    /**
     * @return string[]
     */
    public function getReferencedClasses() : array
    {
        return $this->referencedClasses;
    }
    /**
     * @return RuleError[]
     */
    public function getUnknownClassErrors() : array
    {
        return $this->unknownClassErrors;
    }
}
