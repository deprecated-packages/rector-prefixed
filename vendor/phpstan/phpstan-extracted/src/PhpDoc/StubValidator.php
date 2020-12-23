<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\PhpDoc;

use _PhpScoper0a2ac50786fa\PHPStan\Analyser\FileAnalyser;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\NodeScopeResolver;
use _PhpScoper0a2ac50786fa\PHPStan\Broker\Broker;
use _PhpScoper0a2ac50786fa\PHPStan\DependencyInjection\Container;
use _PhpScoper0a2ac50786fa\PHPStan\DependencyInjection\DerivativeContainerFactory;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Parser\PhpDocParser;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\ClassCaseSensitivityCheck;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Classes\ExistingClassesInClassImplementsRule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Classes\ExistingClassesInInterfaceExtendsRule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Classes\ExistingClassInClassExtendsRule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Classes\ExistingClassInTraitUseRule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\FunctionDefinitionCheck;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Functions\MissingFunctionParameterTypehintRule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Functions\MissingFunctionReturnTypehintRule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\ClassAncestorsRule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\ClassTemplateTypeRule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\FunctionSignatureVarianceRule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\FunctionTemplateTypeRule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\GenericAncestorsCheck;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\GenericObjectTypeCheck;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\InterfaceAncestorsRule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\InterfaceTemplateTypeRule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\MethodSignatureVarianceRule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\MethodTemplateTypeRule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\TemplateTypeCheck;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\TraitTemplateTypeRule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\VarianceCheck;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Methods\ExistingClassesInTypehintsRule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Methods\MissingMethodParameterTypehintRule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Methods\MissingMethodReturnTypehintRule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\MissingTypehintCheck;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\PhpDoc\IncompatiblePhpDocTypeRule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\PhpDoc\IncompatiblePropertyPhpDocTypeRule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\PhpDoc\InvalidPhpDocTagValueRule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\PhpDoc\InvalidThrowsPhpDocValueRule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Properties\ExistingClassesInPropertiesRule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Properties\MissingPropertyTypehintRule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Registry;
use _PhpScoper0a2ac50786fa\PHPStan\Type\FileTypeMapper;
class StubValidator
{
    /** @var \PHPStan\DependencyInjection\DerivativeContainerFactory */
    private $derivativeContainerFactory;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\DependencyInjection\DerivativeContainerFactory $derivativeContainerFactory)
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
        $originalBroker = \_PhpScoper0a2ac50786fa\PHPStan\Broker\Broker::getInstance();
        $container = $this->derivativeContainerFactory->create([__DIR__ . '/../../conf/config.stubValidator.neon']);
        $ruleRegistry = $this->getRuleRegistry($container);
        /** @var FileAnalyser $fileAnalyser */
        $fileAnalyser = $container->getByType(\_PhpScoper0a2ac50786fa\PHPStan\Analyser\FileAnalyser::class);
        /** @var NodeScopeResolver $nodeScopeResolver */
        $nodeScopeResolver = $container->getByType(\_PhpScoper0a2ac50786fa\PHPStan\Analyser\NodeScopeResolver::class);
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
        \_PhpScoper0a2ac50786fa\PHPStan\Broker\Broker::registerInstance($originalBroker);
        return $errors;
    }
    private function getRuleRegistry(\_PhpScoper0a2ac50786fa\PHPStan\DependencyInjection\Container $container) : \_PhpScoper0a2ac50786fa\PHPStan\Rules\Registry
    {
        $fileTypeMapper = $container->getByType(\_PhpScoper0a2ac50786fa\PHPStan\Type\FileTypeMapper::class);
        $genericObjectTypeCheck = $container->getByType(\_PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\GenericObjectTypeCheck::class);
        $genericAncestorsCheck = $container->getByType(\_PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\GenericAncestorsCheck::class);
        $templateTypeCheck = $container->getByType(\_PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\TemplateTypeCheck::class);
        $varianceCheck = $container->getByType(\_PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\VarianceCheck::class);
        $reflectionProvider = $container->getByType(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider::class);
        $classCaseSensitivityCheck = $container->getByType(\_PhpScoper0a2ac50786fa\PHPStan\Rules\ClassCaseSensitivityCheck::class);
        $functionDefinitionCheck = $container->getByType(\_PhpScoper0a2ac50786fa\PHPStan\Rules\FunctionDefinitionCheck::class);
        $missingTypehintCheck = $container->getByType(\_PhpScoper0a2ac50786fa\PHPStan\Rules\MissingTypehintCheck::class);
        return new \_PhpScoper0a2ac50786fa\PHPStan\Rules\Registry([
            // level 0
            new \_PhpScoper0a2ac50786fa\PHPStan\Rules\Classes\ExistingClassesInClassImplementsRule($classCaseSensitivityCheck, $reflectionProvider),
            new \_PhpScoper0a2ac50786fa\PHPStan\Rules\Classes\ExistingClassesInInterfaceExtendsRule($classCaseSensitivityCheck, $reflectionProvider),
            new \_PhpScoper0a2ac50786fa\PHPStan\Rules\Classes\ExistingClassInClassExtendsRule($classCaseSensitivityCheck, $reflectionProvider),
            new \_PhpScoper0a2ac50786fa\PHPStan\Rules\Classes\ExistingClassInTraitUseRule($classCaseSensitivityCheck, $reflectionProvider),
            new \_PhpScoper0a2ac50786fa\PHPStan\Rules\Methods\ExistingClassesInTypehintsRule($functionDefinitionCheck),
            new \_PhpScoper0a2ac50786fa\PHPStan\Rules\Functions\ExistingClassesInTypehintsRule($functionDefinitionCheck),
            new \_PhpScoper0a2ac50786fa\PHPStan\Rules\Properties\ExistingClassesInPropertiesRule($reflectionProvider, $classCaseSensitivityCheck, \true, \false),
            // level 2
            new \_PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\ClassAncestorsRule($fileTypeMapper, $genericAncestorsCheck),
            new \_PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\ClassTemplateTypeRule($templateTypeCheck),
            new \_PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\FunctionTemplateTypeRule($fileTypeMapper, $templateTypeCheck),
            new \_PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\FunctionSignatureVarianceRule($varianceCheck),
            new \_PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\InterfaceAncestorsRule($fileTypeMapper, $genericAncestorsCheck),
            new \_PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\InterfaceTemplateTypeRule($fileTypeMapper, $templateTypeCheck),
            new \_PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\MethodTemplateTypeRule($fileTypeMapper, $templateTypeCheck),
            new \_PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\MethodSignatureVarianceRule($varianceCheck),
            new \_PhpScoper0a2ac50786fa\PHPStan\Rules\Generics\TraitTemplateTypeRule($fileTypeMapper, $templateTypeCheck),
            new \_PhpScoper0a2ac50786fa\PHPStan\Rules\PhpDoc\IncompatiblePhpDocTypeRule($fileTypeMapper, $genericObjectTypeCheck),
            new \_PhpScoper0a2ac50786fa\PHPStan\Rules\PhpDoc\IncompatiblePropertyPhpDocTypeRule($genericObjectTypeCheck),
            new \_PhpScoper0a2ac50786fa\PHPStan\Rules\PhpDoc\InvalidPhpDocTagValueRule($container->getByType(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Lexer\Lexer::class), $container->getByType(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Parser\PhpDocParser::class)),
            new \_PhpScoper0a2ac50786fa\PHPStan\Rules\PhpDoc\InvalidThrowsPhpDocValueRule($fileTypeMapper),
            // level 6
            new \_PhpScoper0a2ac50786fa\PHPStan\Rules\Functions\MissingFunctionParameterTypehintRule($missingTypehintCheck),
            new \_PhpScoper0a2ac50786fa\PHPStan\Rules\Functions\MissingFunctionReturnTypehintRule($missingTypehintCheck),
            new \_PhpScoper0a2ac50786fa\PHPStan\Rules\Methods\MissingMethodParameterTypehintRule($missingTypehintCheck),
            new \_PhpScoper0a2ac50786fa\PHPStan\Rules\Methods\MissingMethodReturnTypehintRule($missingTypehintCheck),
            new \_PhpScoper0a2ac50786fa\PHPStan\Rules\Properties\MissingPropertyTypehintRule($missingTypehintCheck),
        ]);
    }
}
