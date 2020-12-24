<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Analyser;

use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
class ConditionalExpressionHolder
{
    /** @var array<string, Type> */
    private $conditionExpressionTypes;
    /** @var VariableTypeHolder */
    private $typeHolder;
    /**
     * @param array<string, Type> $conditionExpressionTypes
     * @param VariableTypeHolder $typeHolder
     */
    public function __construct(array $conditionExpressionTypes, \_PhpScoperb75b35f52b74\PHPStan\Analyser\VariableTypeHolder $typeHolder)
    {
        if (\count($conditionExpressionTypes) === 0) {
            throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
        }
        $this->conditionExpressionTypes = $conditionExpressionTypes;
        $this->typeHolder = $typeHolder;
    }
    /**
     * @return array<string, Type>
     */
    public function getConditionExpressionTypes() : array
    {
        return $this->conditionExpressionTypes;
    }
    public function getTypeHolder() : \_PhpScoperb75b35f52b74\PHPStan\Analyser\VariableTypeHolder
    {
        return $this->typeHolder;
    }
    public function getKey() : string
    {
        $parts = [];
        foreach ($this->conditionExpressionTypes as $exprString => $type) {
            $parts[] = $exprString . '=' . $type->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::precise());
        }
        return \sprintf('%s => %s (%s)', \implode(' && ', $parts), $this->typeHolder->getType()->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::precise()), $this->typeHolder->getCertainty()->describe());
    }
}
