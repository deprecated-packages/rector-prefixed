<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type;

use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
class BenevolentUnionType extends \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType
{
    public function describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel $level) : string
    {
        return '(' . parent::describe($level) . ')';
    }
    protected function unionTypes(callable $getType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $resultTypes = [];
        foreach ($this->getTypes() as $type) {
            $result = $getType($type);
            if ($result instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
                continue;
            }
            $resultTypes[] = $result;
        }
        if (\count($resultTypes) === 0) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
        }
        return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(...$resultTypes);
    }
    public function isAcceptedBy(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $acceptingType->accepts($innerType, $strictTypes);
        }
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo()->or(...$results);
    }
    public function traverse(callable $cb) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $types = [];
        $changed = \false;
        foreach ($this->getTypes() as $type) {
            $newType = $cb($type);
            if ($type !== $newType) {
                $changed = \true;
            }
            $types[] = $newType;
        }
        if ($changed) {
            return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::toBenevolentUnion(\_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(...$types));
        }
        return $this;
    }
}
