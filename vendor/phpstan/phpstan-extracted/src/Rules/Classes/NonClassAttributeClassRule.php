<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Classes;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Node\InClassNode;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleError;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<InClassNode>
 */
class NonClassAttributeClassRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\Node\InClassNode::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $originalNode = $node->getOriginalNode();
        foreach ($originalNode->attrGroups as $attrGroup) {
            foreach ($attrGroup->attrs as $attr) {
                $name = $attr->name->toLowerString();
                if ($name === 'attribute') {
                    return $this->check($scope);
                }
            }
        }
        return [];
    }
    /**
     * @param Scope $scope
     * @return RuleError[]
     */
    private function check(\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->isInClass()) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        $classReflection = $scope->getClassReflection();
        if (!$classReflection->isClass()) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message('Interface cannot be an Attribute class.')->build()];
        }
        if ($classReflection->isAbstract()) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Abstract class %s cannot be an Attribute class.', $classReflection->getDisplayName()))->build()];
        }
        if (!$classReflection->hasConstructor()) {
            return [];
        }
        if (!$classReflection->getConstructor()->isPublic()) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Attribute class %s constructor must be public.', $classReflection->getDisplayName()))->build()];
        }
        return [];
    }
}
