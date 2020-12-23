<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\FamilyTree\Reflection;

final class FamilyRelationsAnalyzer
{
    /**
     * @return class-string[]
     */
    public function getChildrenOfClass(string $parentClass) : array
    {
        $childrenClasses = [];
        foreach (\get_declared_classes() as $declaredClass) {
            if ($declaredClass === $parentClass) {
                continue;
            }
            if (!\is_a($declaredClass, $parentClass, \true)) {
                continue;
            }
            $childrenClasses[] = $declaredClass;
        }
        return $childrenClasses;
    }
    public function isParentClass(string $class) : bool
    {
        foreach (\get_declared_classes() as $declaredClass) {
            if ($declaredClass === $class) {
                continue;
            }
            if (!\is_a($declaredClass, $class, \true)) {
                continue;
            }
            return \true;
        }
        return \false;
    }
}
