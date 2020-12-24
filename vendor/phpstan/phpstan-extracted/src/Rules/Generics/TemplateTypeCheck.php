<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Generics;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;
use _PhpScoperb75b35f52b74\PHPStan\Rules\ClassCaseSensitivityCheck;
use _PhpScoperb75b35f52b74\PHPStan\Rules\ClassNameNodePair;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeScope;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
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
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScoperb75b35f52b74\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, array $typeAliases, bool $checkClassCaseSensitivity)
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
    public function check(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeScope $templateTypeScope, array $templateTags, string $sameTemplateTypeNameAsClassMessage, string $sameTemplateTypeNameAsTypeMessage, string $invalidBoundTypeMessage, string $notSupportedBoundMessage) : array
    {
        $messages = [];
        foreach ($templateTags as $templateTag) {
            $templateTagName = $templateTag->getName();
            if ($this->reflectionProvider->hasClass($templateTagName)) {
                $messages[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($sameTemplateTypeNameAsClassMessage, $templateTagName))->build();
            }
            if (\array_key_exists($templateTagName, $this->typeAliases)) {
                $messages[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($sameTemplateTypeNameAsTypeMessage, $templateTagName))->build();
            }
            $boundType = $templateTag->getBound();
            foreach ($boundType->getReferencedClasses() as $referencedClass) {
                if ($this->reflectionProvider->hasClass($referencedClass) && !$this->reflectionProvider->getClass($referencedClass)->isTrait()) {
                    continue;
                }
                $messages[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($invalidBoundTypeMessage, $templateTagName, $referencedClass))->build();
            }
            if ($this->checkClassCaseSensitivity) {
                $classNameNodePairs = \array_map(static function (string $referencedClass) use($node) : ClassNameNodePair {
                    return new \_PhpScoperb75b35f52b74\PHPStan\Rules\ClassNameNodePair($referencedClass, $node);
                }, $boundType->getReferencedClasses());
                $messages = \array_merge($messages, $this->classCaseSensitivityCheck->checkClassNames($classNameNodePairs));
            }
            $bound = $templateTag->getBound();
            $boundClass = \get_class($bound);
            if ($boundClass === \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType::class || $boundClass === \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType::class || $bound instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
                continue;
            }
            $messages[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($notSupportedBoundMessage, $templateTagName, $boundType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
        }
        return $messages;
    }
}
