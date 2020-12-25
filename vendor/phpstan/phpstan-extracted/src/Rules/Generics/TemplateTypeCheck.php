<?php

declare (strict_types=1);
namespace PHPStan\Rules\Generics;

use PhpParser\Node;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\ClassCaseSensitivityCheck;
use PHPStan\Rules\ClassNameNodePair;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\Generic\TemplateTypeScope;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\VerbosityLevel;
use function array_key_exists;
use function array_map;
class TemplateTypeCheck
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Rules\ClassCaseSensitivityCheck */
    private $classCaseSensitivityCheck;
    /** @var array<string, string> */
    private $typeAliases;
    /** @var bool */
    private $checkClassCaseSensitivity;
    /**
     * @param ReflectionProvider $reflectionProvider
     * @param ClassCaseSensitivityCheck $classCaseSensitivityCheck
     * @param array<string, string> $typeAliases
     * @param bool $checkClassCaseSensitivity
     */
    public function __construct(\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, array $typeAliases, bool $checkClassCaseSensitivity)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
        $this->typeAliases = $typeAliases;
        $this->checkClassCaseSensitivity = $checkClassCaseSensitivity;
    }
    /**
     * @param \PhpParser\Node $node
     * @param \PHPStan\Type\Generic\TemplateTypeScope $templateTypeScope
     * @param array<string, \PHPStan\PhpDoc\Tag\TemplateTag> $templateTags
     * @return \PHPStan\Rules\RuleError[]
     */
    public function check(\PhpParser\Node $node, \PHPStan\Type\Generic\TemplateTypeScope $templateTypeScope, array $templateTags, string $sameTemplateTypeNameAsClassMessage, string $sameTemplateTypeNameAsTypeMessage, string $invalidBoundTypeMessage, string $notSupportedBoundMessage) : array
    {
        $messages = [];
        foreach ($templateTags as $templateTag) {
            $templateTagName = $templateTag->getName();
            if ($this->reflectionProvider->hasClass($templateTagName)) {
                $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf($sameTemplateTypeNameAsClassMessage, $templateTagName))->build();
            }
            if (\array_key_exists($templateTagName, $this->typeAliases)) {
                $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf($sameTemplateTypeNameAsTypeMessage, $templateTagName))->build();
            }
            $boundType = $templateTag->getBound();
            foreach ($boundType->getReferencedClasses() as $referencedClass) {
                if ($this->reflectionProvider->hasClass($referencedClass) && !$this->reflectionProvider->getClass($referencedClass)->isTrait()) {
                    continue;
                }
                $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf($invalidBoundTypeMessage, $templateTagName, $referencedClass))->build();
            }
            if ($this->checkClassCaseSensitivity) {
                $classNameNodePairs = \array_map(static function (string $referencedClass) use($node) : ClassNameNodePair {
                    return new \PHPStan\Rules\ClassNameNodePair($referencedClass, $node);
                }, $boundType->getReferencedClasses());
                $messages = \array_merge($messages, $this->classCaseSensitivityCheck->checkClassNames($classNameNodePairs));
            }
            $bound = $templateTag->getBound();
            $boundClass = \get_class($bound);
            if ($boundClass === \PHPStan\Type\MixedType::class || $boundClass === \PHPStan\Type\ObjectWithoutClassType::class || $bound instanceof \PHPStan\Type\ObjectType) {
                continue;
            }
            $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf($notSupportedBoundMessage, $templateTagName, $boundType->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
        }
        return $messages;
    }
}
