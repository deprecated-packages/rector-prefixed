<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\FileAnalyser;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\NodeScopeResolver;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Broker\Broker;
use _PhpScoper2a4e7ab1ecbc\PHPStan\DependencyInjection\Container;
use _PhpScoper2a4e7ab1ecbc\PHPStan\DependencyInjection\DerivativeContainerFactory;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Lexer\Lexer;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Parser\PhpDocParser;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\ClassCaseSensitivityCheck;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Classes\ExistingClassesInClassImplementsRule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Classes\ExistingClassesInInterfaceExtendsRule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Classes\ExistingClassInClassExtendsRule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Classes\ExistingClassInTraitUseRule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\FunctionDefinitionCheck;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Functions\MissingFunctionParameterTypehintRule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Functions\MissingFunctionReturnTypehintRule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Generics\ClassAncestorsRule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Generics\ClassTemplateTypeRule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Generics\FunctionSignatureVarianceRule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Generics\FunctionTemplateTypeRule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Generics\GenericAncestorsCheck;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Generics\GenericObjectTypeCheck;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Generics\InterfaceAncestorsRule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Generics\InterfaceTemplateTypeRule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Generics\MethodSignatureVarianceRule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Generics\MethodTemplateTypeRule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Generics\TemplateTypeCheck;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Generics\TraitTemplateTypeRule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Generics\VarianceCheck;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Methods\ExistingClassesInTypehintsRule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Methods\MissingMethodParameterTypehintRule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Methods\MissingMethodReturnTypehintRule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\MissingTypehintCheck;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\PhpDoc\IncompatiblePhpDocTypeRule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\PhpDoc\IncompatiblePropertyPhpDocTypeRule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\PhpDoc\InvalidPhpDocTagValueRule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\PhpDoc\InvalidThrowsPhpDocValueRule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Properties\ExistingClassesInPropertiesRule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Properties\MissingPropertyTypehintRule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Registry;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\FileTypeMapper;
class StubValidator
{
    /** @var \PHPStan\DependencyInjection\DerivativeContainerFactory */
    private $derivativeContainerFactory;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\DependencyInjection\DerivativeContainerFactory $derivativeContainerFactory)
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
        $originalBroker = \_PhpScoper2a4e7ab1ecbc\PHPStan\Broker\Broker::getInstance();
        $container = $this->derivativeContainerFactory->create([__DIR__ . '/../../conf/config.stubValidator.neon']);
        $ruleRegistry = $this->getRuleRegistry($container);
        /** @var FileAnalyser $fileAnalyser */
        $fileAnalyser = $container->getByType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\FileAnalyser::class);
        /** @var NodeScopeResolver $nodeScopeResolver */
        $nodeScopeResolver = $container->getByType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\NodeScopeResolver::class);
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
        \_PhpScoper2a4e7ab1ecbc\PHPStan\Broker\Broker::registerInstance($originalBroker);
        return $errors;
    }
    private function getRuleRegistry(\_PhpScoper2a4e7ab1ecbc\PHPStan\DependencyInjection\Container $container) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Registry
    {
        $fileTypeMapper = $container->getByType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\FileTypeMapper::class);
        $genericObjectTypeCheck = $container->getByType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Generics\GenericObjectTypeCheck::class);
        $genericAncestorsCheck = $container->getByType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Generics\GenericAncestorsCheck::class);
        $templateTypeCheck = $container->getByType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Generics\TemplateTypeCheck::class);
        $varianceCheck = $container->getByType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Generics\VarianceCheck::class);
        $reflectionProvider = $container->getByType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider::class);
        $classCaseSensitivityCheck = $container->getByType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\ClassCaseSensitivityCheck::class);
        $functionDefinitionCheck = $container->getByType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\FunctionDefinitionCheck::class);
        $missingTypehintCheck = $container->getByType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\MissingTypehintCheck::class);
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Registry([
            // level 0
            new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Classes\ExistingClassesInClassImplementsRule($classCaseSensitivityCheck, $reflectionProvider),
            new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Classes\ExistingClassesInInterfaceExtendsRule($classCaseSensitivityCheck, $reflectionProvider),
            new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Classes\ExistingClassInClassExtendsRule($classCaseSensitivityCheck, $reflectionProvider),
            new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Classes\ExistingClassInTraitUseRule($classCaseSensitivityCheck, $reflectionProvider),
            new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Methods\ExistingClassesInTypehintsRule($functionDefinitionCheck),
            new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Functions\ExistingClassesInTypehintsRule($functionDefinitionCheck),
            new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Properties\ExistingClassesInPropertiesRule($reflectionProvider, $classCaseSensitivityCheck, \true, \false),
            // level 2
            new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Generics\ClassAncestorsRule($fileTypeMapper, $genericAncestorsCheck),
            new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Generics\ClassTemplateTypeRule($templateTypeCheck),
            new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Generics\FunctionTemplateTypeRule($fileTypeMapper, $templateTypeCheck),
            new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Generics\FunctionSignatureVarianceRule($varianceCheck),
            new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Generics\InterfaceAncestorsRule($fileTypeMapper, $genericAncestorsCheck),
            new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Generics\InterfaceTemplateTypeRule($fileTypeMapper, $templateTypeCheck),
            new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Generics\MethodTemplateTypeRule($fileTypeMapper, $templateTypeCheck),
            new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Generics\MethodSignatureVarianceRule($varianceCheck),
            new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Generics\TraitTemplateTypeRule($fileTypeMapper, $templateTypeCheck),
            new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\PhpDoc\IncompatiblePhpDocTypeRule($fileTypeMapper, $genericObjectTypeCheck),
            new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\PhpDoc\IncompatiblePropertyPhpDocTypeRule($genericObjectTypeCheck),
            new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\PhpDoc\InvalidPhpDocTagValueRule($container->getByType(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Lexer\Lexer::class), $container->getByType(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Parser\PhpDocParser::class)),
            new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\PhpDoc\InvalidThrowsPhpDocValueRule($fileTypeMapper),
            // level 6
            new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Functions\MissingFunctionParameterTypehintRule($missingTypehintCheck),
            new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Functions\MissingFunctionReturnTypehintRule($missingTypehintCheck),
            new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Methods\MissingMethodParameterTypehintRule($missingTypehintCheck),
            new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Methods\MissingMethodReturnTypehintRule($missingTypehintCheck),
            new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Properties\MissingPropertyTypehintRule($missingTypehintCheck),
        ]);
    }
}
