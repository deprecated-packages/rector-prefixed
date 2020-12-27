<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Classes;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Node\InClassNode;
use RectorPrefix20201227\PHPStan\Rules\Rule;
use RectorPrefix20201227\PHPStan\Rules\RuleError;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<InClassNode>
 */
class NonClassAttributeClassRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \RectorPrefix20201227\PHPStan\Node\InClassNode::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
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
    private function check(\RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->isInClass()) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        $classReflection = $scope->getClassReflection();
        if (!$classReflection->isClass()) {
            return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message('Interface cannot be an Attribute class.')->build()];
        }
        if ($classReflection->isAbstract()) {
            return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Abstract class %s cannot be an Attribute class.', $classReflection->getDisplayName()))->build()];
        }
        if (!$classReflection->hasConstructor()) {
            return [];
        }
        if (!$classReflection->getConstructor()->isPublic()) {
            return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Attribute class %s constructor must be public.', $classReflection->getDisplayName()))->build()];
        }
        return [];
    }
}
