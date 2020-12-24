<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\PhpDoc;

use _PhpScopere8e811afab72\PHPStan\Analyser\FileAnalyser;
use _PhpScopere8e811afab72\PHPStan\Analyser\NodeScopeResolver;
use _PhpScopere8e811afab72\PHPStan\Broker\Broker;
use _PhpScopere8e811afab72\PHPStan\DependencyInjection\Container;
use _PhpScopere8e811afab72\PHPStan\DependencyInjection\DerivativeContainerFactory;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\PhpDocParser;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\PHPStan\Rules\ClassCaseSensitivityCheck;
use _PhpScopere8e811afab72\PHPStan\Rules\Classes\ExistingClassesInClassImplementsRule;
use _PhpScopere8e811afab72\PHPStan\Rules\Classes\ExistingClassesInInterfaceExtendsRule;
use _PhpScopere8e811afab72\PHPStan\Rules\Classes\ExistingClassInClassExtendsRule;
use _PhpScopere8e811afab72\PHPStan\Rules\Classes\ExistingClassInTraitUseRule;
use _PhpScopere8e811afab72\PHPStan\Rules\FunctionDefinitionCheck;
use _PhpScopere8e811afab72\PHPStan\Rules\Functions\MissingFunctionParameterTypehintRule;
use _PhpScopere8e811afab72\PHPStan\Rules\Functions\MissingFunctionReturnTypehintRule;
use _PhpScopere8e811afab72\PHPStan\Rules\Generics\ClassAncestorsRule;
use _PhpScopere8e811afab72\PHPStan\Rules\Generics\ClassTemplateTypeRule;
use _PhpScopere8e811afab72\PHPStan\Rules\Generics\FunctionSignatureVarianceRule;
use _PhpScopere8e811afab72\PHPStan\Rules\Generics\FunctionTemplateTypeRule;
use _PhpScopere8e811afab72\PHPStan\Rules\Generics\GenericAncestorsCheck;
use _PhpScopere8e811afab72\PHPStan\Rules\Generics\GenericObjectTypeCheck;
use _PhpScopere8e811afab72\PHPStan\Rules\Generics\InterfaceAncestorsRule;
use _PhpScopere8e811afab72\PHPStan\Rules\Generics\InterfaceTemplateTypeRule;
use _PhpScopere8e811afab72\PHPStan\Rules\Generics\MethodSignatureVarianceRule;
use _PhpScopere8e811afab72\PHPStan\Rules\Generics\MethodTemplateTypeRule;
use _PhpScopere8e811afab72\PHPStan\Rules\Generics\TemplateTypeCheck;
use _PhpScopere8e811afab72\PHPStan\Rules\Generics\TraitTemplateTypeRule;
use _PhpScopere8e811afab72\PHPStan\Rules\Generics\VarianceCheck;
use _PhpScopere8e811afab72\PHPStan\Rules\Methods\ExistingClassesInTypehintsRule;
use _PhpScopere8e811afab72\PHPStan\Rules\Methods\MissingMethodParameterTypehintRule;
use _PhpScopere8e811afab72\PHPStan\Rules\Methods\MissingMethodReturnTypehintRule;
use _PhpScopere8e811afab72\PHPStan\Rules\MissingTypehintCheck;
use _PhpScopere8e811afab72\PHPStan\Rules\PhpDoc\IncompatiblePhpDocTypeRule;
use _PhpScopere8e811afab72\PHPStan\Rules\PhpDoc\IncompatiblePropertyPhpDocTypeRule;
use _PhpScopere8e811afab72\PHPStan\Rules\PhpDoc\InvalidPhpDocTagValueRule;
use _PhpScopere8e811afab72\PHPStan\Rules\PhpDoc\InvalidThrowsPhpDocValueRule;
use _PhpScopere8e811afab72\PHPStan\Rules\Properties\ExistingClassesInPropertiesRule;
use _PhpScopere8e811afab72\PHPStan\Rules\Properties\MissingPropertyTypehintRule;
use _PhpScopere8e811afab72\PHPStan\Rules\Registry;
use _PhpScopere8e811afab72\PHPStan\Type\FileTypeMapper;
class StubValidator
{
    /** @var \PHPStan\DependencyInjection\DerivativeContainerFactory */
    private $derivativeContainerFactory;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\DependencyInjection\DerivativeContainerFactory $derivativeContainerFactory)
    {
        $this->derivativeContainerFactory = $derivativeContainerFactory;
    }
    /**
     * @param string[] $stubFiles
     * @return \PHPStan\Analyser\Error[]
     */
    public function validate(array $stubFiles) : array
    {
        if (\count($stubFiles) === 0) {
            return [];
        }
        $originalBroker = \_PhpScopere8e811afab72\PHPStan\Broker\Broker::getInstance();
        $container = $this->derivativeContainerFactory->create([__DIR__ . '/../../conf/config.stubValidator.neon']);
        $ruleRegistry = $this->getRuleRegistry($container);
        /** @var FileAnalyser $fileAnalyser */
        $fileAnalyser = $container->getByType(\_PhpScopere8e811afab72\PHPStan\Analyser\FileAnalyser::class);
        /** @var NodeScopeResolver $nodeScopeResolver */
        $nodeScopeResolver = $container->getByType(\_PhpScopere8e811afab72\PHPStan\Analyser\NodeScopeResolver::class);
        $nodeScopeResolver->setAnalysedFiles($stubFiles);
        $analysedFiles = \array_fill_keys($stubFiles, \true);
        $errors = [];
        foreach ($stubFiles as $stubFile) {
            $tmpErrors = $fileAnalyser->analyseFile($stubFile, $analysedFiles, $ruleRegistry, static function () : void {
            })->getErrors();
            foreach ($tmpErrors as $tmpError) {
                $errors[] = $tmpError->withoutTip();
            }
        }
        \_PhpScopere8e811afab72\PHPStan\Broker\Broker::registerInstance($originalBroker);
        return $errors;
    }
    private function getRuleRegistry(\_PhpScopere8e811afab72\PHPStan\DependencyInjection\Container $container) : \_PhpScopere8e811afab72\PHPStan\Rules\Registry
    {
        $fileTypeMapper = $container->getByType(\_PhpScopere8e811afab72\PHPStan\Type\FileTypeMapper::class);
        $genericObjectTypeCheck = $container->getByType(\_PhpScopere8e811afab72\PHPStan\Rules\Generics\GenericObjectTypeCheck::class);
        $genericAncestorsCheck = $container->getByType(\_PhpScopere8e811afab72\PHPStan\Rules\Generics\GenericAncestorsCheck::class);
        $templateTypeCheck = $container->getByType(\_PhpScopere8e811afab72\PHPStan\Rules\Generics\TemplateTypeCheck::class);
        $varianceCheck = $container->getByType(\_PhpScopere8e811afab72\PHPStan\Rules\Generics\VarianceCheck::class);
        $reflectionProvider = $container->getByType(\_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider::class);
        $classCaseSensitivityCheck = $container->getByType(\_PhpScopere8e811afab72\PHPStan\Rules\ClassCaseSensitivityCheck::class);
        $functionDefinitionCheck = $container->getByType(\_PhpScopere8e811afab72\PHPStan\Rules\FunctionDefinitionCheck::class);
        $missingTypehintCheck = $container->getByType(\_PhpScopere8e811afab72\PHPStan\Rules\MissingTypehintCheck::class);
        return new \_PhpScopere8e811afab72\PHPStan\Rules\Registry([
            // level 0
            new \_PhpScopere8e811afab72\PHPStan\Rules\Classes\ExistingClassesInClassImplementsRule($classCaseSensitivityCheck, $reflectionProvider),
            new \_PhpScopere8e811afab72\PHPStan\Rules\Classes\ExistingClassesInInterfaceExtendsRule($classCaseSensitivityCheck, $reflectionProvider),
            new \_PhpScopere8e811afab72\PHPStan\Rules\Classes\ExistingClassInClassExtendsRule($classCaseSensitivityCheck, $reflectionProvider),
            new \_PhpScopere8e811afab72\PHPStan\Rules\Classes\ExistingClassInTraitUseRule($classCaseSensitivityCheck, $reflectionProvider),
            new \_PhpScopere8e811afab72\PHPStan\Rules\Methods\ExistingClassesInTypehintsRule($functionDefinitionCheck),
            new \_PhpScopere8e811afab72\PHPStan\Rules\Functions\ExistingClassesInTypehintsRule($functionDefinitionCheck),
            new \_PhpScopere8e811afab72\PHPStan\Rules\Properties\ExistingClassesInPropertiesRule($reflectionProvider, $classCaseSensitivityCheck, \true, \false),
            // level 2
            new \_PhpScopere8e811afab72\PHPStan\Rules\Generics\ClassAncestorsRule($fileTypeMapper, $genericAncestorsCheck),
            new \_PhpScopere8e811afab72\PHPStan\Rules\Generics\ClassTemplateTypeRule($templateTypeCheck),
            new \_PhpScopere8e811afab72\PHPStan\Rules\Generics\FunctionTemplateTypeRule($fileTypeMapper, $templateTypeCheck),
            new \_PhpScopere8e811afab72\PHPStan\Rules\Generics\FunctionSignatureVarianceRule($varianceCheck),
            new \_PhpScopere8e811afab72\PHPStan\Rules\Generics\InterfaceAncestorsRule($fileTypeMapper, $genericAncestorsCheck),
            new \_PhpScopere8e811afab72\PHPStan\Rules\Generics\InterfaceTemplateTypeRule($fileTypeMapper, $templateTypeCheck),
            new \_PhpScopere8e811afab72\PHPStan\Rules\Generics\MethodTemplateTypeRule($fileTypeMapper, $templateTypeCheck),
            new \_PhpScopere8e811afab72\PHPStan\Rules\Generics\MethodSignatureVarianceRule($varianceCheck),
            new \_PhpScopere8e811afab72\PHPStan\Rules\Generics\TraitTemplateTypeRule($fileTypeMapper, $templateTypeCheck),
            new \_PhpScopere8e811afab72\PHPStan\Rules\PhpDoc\IncompatiblePhpDocTypeRule($fileTypeMapper, $genericObjectTypeCheck),
            new \_PhpScopere8e811afab72\PHPStan\Rules\PhpDoc\IncompatiblePropertyPhpDocTypeRule($genericObjectTypeCheck),
            new \_PhpScopere8e811afab72\PHPStan\Rules\PhpDoc\InvalidPhpDocTagValueRule($container->getByType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Lexer\Lexer::class), $container->getByType(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Parser\PhpDocParser::class)),
            new \_PhpScopere8e811afab72\PHPStan\Rules\PhpDoc\InvalidThrowsPhpDocValueRule($fileTypeMapper),
            // level 6
            new \_PhpScopere8e811afab72\PHPStan\Rules\Functions\MissingFunctionParameterTypehintRule($missingTypehintCheck),
            new \_PhpScopere8e811afab72\PHPStan\Rules\Functions\MissingFunctionReturnTypehintRule($missingTypehintCheck),
            new \_PhpScopere8e811afab72\PHPStan\Rules\Methods\MissingMethodParameterTypehintRule($missingTypehintCheck),
            new \_PhpScopere8e811afab72\PHPStan\Rules\Methods\MissingMethodReturnTypehintRule($missingTypehintCheck),
            new \_PhpScopere8e811afab72\PHPStan\Rules\Properties\MissingPropertyTypehintRule($missingTypehintCheck),
        ]);
    }
}
