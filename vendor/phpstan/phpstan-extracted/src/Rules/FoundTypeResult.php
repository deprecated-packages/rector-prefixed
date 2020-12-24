<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules;

use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
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
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, array $referencedClasses, array $unknownClassErrors)
    {
        $this->type = $type;
        $this->referencedClasses = $referencedClasses;
        $this->unknownClassErrors = $unknownClassErrors;
    }
    public function getType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
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
