<?php

declare (strict_types=1);
namespace PHPStan\PhpDoc;

use PHPStan\Analyser\FileAnalyser;
use PHPStan\Analyser\NodeScopeResolver;
use PHPStan\Broker\Broker;
use PHPStan\DependencyInjection\Container;
use PHPStan\DependencyInjection\DerivativeContainerFactory;
use PHPStan\PhpDocParser\Lexer\Lexer;
use PHPStan\PhpDocParser\Parser\PhpDocParser;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\ClassCaseSensitivityCheck;
use PHPStan\Rules\Classes\ExistingClassesInClassImplementsRule;
use PHPStan\Rules\Classes\ExistingClassesInInterfaceExtendsRule;
use PHPStan\Rules\Classes\ExistingClassInClassExtendsRule;
use PHPStan\Rules\Classes\ExistingClassInTraitUseRule;
use PHPStan\Rules\FunctionDefinitionCheck;
use PHPStan\Rules\Functions\MissingFunctionParameterTypehintRule;
use PHPStan\Rules\Functions\MissingFunctionReturnTypehintRule;
use PHPStan\Rules\Generics\ClassAncestorsRule;
use PHPStan\Rules\Generics\ClassTemplateTypeRule;
use PHPStan\Rules\Generics\FunctionSignatureVarianceRule;
use PHPStan\Rules\Generics\FunctionTemplateTypeRule;
use PHPStan\Rules\Generics\GenericAncestorsCheck;
use PHPStan\Rules\Generics\GenericObjectTypeCheck;
use PHPStan\Rules\Generics\InterfaceAncestorsRule;
use PHPStan\Rules\Generics\InterfaceTemplateTypeRule;
use PHPStan\Rules\Generics\MethodSignatureVarianceRule;
use PHPStan\Rules\Generics\MethodTemplateTypeRule;
use PHPStan\Rules\Generics\TemplateTypeCheck;
use PHPStan\Rules\Generics\TraitTemplateTypeRule;
use PHPStan\Rules\Generics\VarianceCheck;
use PHPStan\Rules\Methods\ExistingClassesInTypehintsRule;
use PHPStan\Rules\Methods\MissingMethodParameterTypehintRule;
use PHPStan\Rules\Methods\MissingMethodReturnTypehintRule;
use PHPStan\Rules\MissingTypehintCheck;
use PHPStan\Rules\PhpDoc\IncompatiblePhpDocTypeRule;
use PHPStan\Rules\PhpDoc\IncompatiblePropertyPhpDocTypeRule;
use PHPStan\Rules\PhpDoc\InvalidPhpDocTagValueRule;
use PHPStan\Rules\PhpDoc\InvalidThrowsPhpDocValueRule;
use PHPStan\Rules\Properties\ExistingClassesInPropertiesRule;
use PHPStan\Rules\Properties\MissingPropertyTypehintRule;
use PHPStan\Rules\Registry;
use PHPStan\Type\FileTypeMapper;
class StubValidator
{
    /** @var \PHPStan\DependencyInjection\DerivativeContainerFactory */
    private $derivativeContainerFactory;
    public function __construct(\PHPStan\DependencyInjection\DerivativeContainerFactory $derivativeContainerFactory)
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
        $originalBroker = \PHPStan\Broker\Broker::getInstance();
        $container = $this->derivativeContainerFactory->create([__DIR__ . '/../../conf/config.stubValidator.neon']);
        $ruleRegistry = $this->getRuleRegistry($container);
        /** @var FileAnalyser $fileAnalyser */
        $fileAnalyser = $container->getByType(\PHPStan\Analyser\FileAnalyser::class);
        /** @var NodeScopeResolver $nodeScopeResolver */
        $nodeScopeResolver = $container->getByType(\PHPStan\Analyser\NodeScopeResolver::class);
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
        \PHPStan\Broker\Broker::registerInstance($originalBroker);
        return $errors;
    }
    private function getRuleRegistry(\PHPStan\DependencyInjection\Container $container) : \PHPStan\Rules\Registry
    {
        $fileTypeMapper = $container->getByType(\PHPStan\Type\FileTypeMapper::class);
        $genericObjectTypeCheck = $container->getByType(\PHPStan\Rules\Generics\GenericObjectTypeCheck::class);
        $genericAncestorsCheck = $container->getByType(\PHPStan\Rules\Generics\GenericAncestorsCheck::class);
        $templateTypeCheck = $container->getByType(\PHPStan\Rules\Generics\TemplateTypeCheck::class);
        $varianceCheck = $container->getByType(\PHPStan\Rules\Generics\VarianceCheck::class);
        $reflectionProvider = $container->getByType(\PHPStan\Reflection\ReflectionProvider::class);
        $classCaseSensitivityCheck = $container->getByType(\PHPStan\Rules\ClassCaseSensitivityCheck::class);
        $functionDefinitionCheck = $container->getByType(\PHPStan\Rules\FunctionDefinitionCheck::class);
        $missingTypehintCheck = $container->getByType(\PHPStan\Rules\MissingTypehintCheck::class);
        return new \PHPStan\Rules\Registry([
            // level 0
            new \PHPStan\Rules\Classes\ExistingClassesInClassImplementsRule($classCaseSensitivityCheck, $reflectionProvider),
            new \PHPStan\Rules\Classes\ExistingClassesInInterfaceExtendsRule($classCaseSensitivityCheck, $reflectionProvider),
            new \PHPStan\Rules\Classes\ExistingClassInClassExtendsRule($classCaseSensitivityCheck, $reflectionProvider),
            new \PHPStan\Rules\Classes\ExistingClassInTraitUseRule($classCaseSensitivityCheck, $reflectionProvider),
            new \PHPStan\Rules\Methods\ExistingClassesInTypehintsRule($functionDefinitionCheck),
            new \PHPStan\Rules\Functions\ExistingClassesInTypehintsRule($functionDefinitionCheck),
            new \PHPStan\Rules\Properties\ExistingClassesInPropertiesRule($reflectionProvider, $classCaseSensitivityCheck, \true, \false),
            // level 2
            new \PHPStan\Rules\Generics\ClassAncestorsRule($fileTypeMapper, $genericAncestorsCheck),
            new \PHPStan\Rules\Generics\ClassTemplateTypeRule($templateTypeCheck),
            new \PHPStan\Rules\Generics\FunctionTemplateTypeRule($fileTypeMapper, $templateTypeCheck),
            new \PHPStan\Rules\Generics\FunctionSignatureVarianceRule($varianceCheck),
            new \PHPStan\Rules\Generics\InterfaceAncestorsRule($fileTypeMapper, $genericAncestorsCheck),
            new \PHPStan\Rules\Generics\InterfaceTemplateTypeRule($fileTypeMapper, $templateTypeCheck),
            new \PHPStan\Rules\Generics\MethodTemplateTypeRule($fileTypeMapper, $templateTypeCheck),
            new \PHPStan\Rules\Generics\MethodSignatureVarianceRule($varianceCheck),
            new \PHPStan\Rules\Generics\TraitTemplateTypeRule($fileTypeMapper, $templateTypeCheck),
            new \PHPStan\Rules\PhpDoc\IncompatiblePhpDocTypeRule($fileTypeMapper, $genericObjectTypeCheck),
            new \PHPStan\Rules\PhpDoc\IncompatiblePropertyPhpDocTypeRule($genericObjectTypeCheck),
            new \PHPStan\Rules\PhpDoc\InvalidPhpDocTagValueRule($container->getByType(\PHPStan\PhpDocParser\Lexer\Lexer::class), $container->getByType(\PHPStan\PhpDocParser\Parser\PhpDocParser::class)),
            new \PHPStan\Rules\PhpDoc\InvalidThrowsPhpDocValueRule($fileTypeMapper),
            // level 6
            new \PHPStan\Rules\Functions\MissingFunctionParameterTypehintRule($missingTypehintCheck),
            new \PHPStan\Rules\Functions\MissingFunctionReturnTypehintRule($missingTypehintCheck),
            new \PHPStan\Rules\Methods\MissingMethodParameterTypehintRule($missingTypehintCheck),
            new \PHPStan\Rules\Methods\MissingMethodReturnTypehintRule($missingTypehintCheck),
            new \PHPStan\Rules\Properties\MissingPropertyTypehintRule($missingTypehintCheck),
        ]);
    }
}
