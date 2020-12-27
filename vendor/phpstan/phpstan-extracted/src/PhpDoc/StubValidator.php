<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\PhpDoc;

use RectorPrefix20201227\PHPStan\Analyser\FileAnalyser;
use RectorPrefix20201227\PHPStan\Analyser\NodeScopeResolver;
use RectorPrefix20201227\PHPStan\Broker\Broker;
use RectorPrefix20201227\PHPStan\DependencyInjection\Container;
use RectorPrefix20201227\PHPStan\DependencyInjection\DerivativeContainerFactory;
use RectorPrefix20201227\PHPStan\PhpDocParser\Lexer\Lexer;
use RectorPrefix20201227\PHPStan\PhpDocParser\Parser\PhpDocParser;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
use RectorPrefix20201227\PHPStan\Rules\ClassCaseSensitivityCheck;
use RectorPrefix20201227\PHPStan\Rules\Classes\ExistingClassesInClassImplementsRule;
use RectorPrefix20201227\PHPStan\Rules\Classes\ExistingClassesInInterfaceExtendsRule;
use RectorPrefix20201227\PHPStan\Rules\Classes\ExistingClassInClassExtendsRule;
use RectorPrefix20201227\PHPStan\Rules\Classes\ExistingClassInTraitUseRule;
use RectorPrefix20201227\PHPStan\Rules\FunctionDefinitionCheck;
use RectorPrefix20201227\PHPStan\Rules\Functions\MissingFunctionParameterTypehintRule;
use RectorPrefix20201227\PHPStan\Rules\Functions\MissingFunctionReturnTypehintRule;
use RectorPrefix20201227\PHPStan\Rules\Generics\ClassAncestorsRule;
use RectorPrefix20201227\PHPStan\Rules\Generics\ClassTemplateTypeRule;
use RectorPrefix20201227\PHPStan\Rules\Generics\FunctionSignatureVarianceRule;
use RectorPrefix20201227\PHPStan\Rules\Generics\FunctionTemplateTypeRule;
use RectorPrefix20201227\PHPStan\Rules\Generics\GenericAncestorsCheck;
use RectorPrefix20201227\PHPStan\Rules\Generics\GenericObjectTypeCheck;
use RectorPrefix20201227\PHPStan\Rules\Generics\InterfaceAncestorsRule;
use RectorPrefix20201227\PHPStan\Rules\Generics\InterfaceTemplateTypeRule;
use RectorPrefix20201227\PHPStan\Rules\Generics\MethodSignatureVarianceRule;
use RectorPrefix20201227\PHPStan\Rules\Generics\MethodTemplateTypeRule;
use RectorPrefix20201227\PHPStan\Rules\Generics\TemplateTypeCheck;
use RectorPrefix20201227\PHPStan\Rules\Generics\TraitTemplateTypeRule;
use RectorPrefix20201227\PHPStan\Rules\Generics\VarianceCheck;
use RectorPrefix20201227\PHPStan\Rules\Methods\ExistingClassesInTypehintsRule;
use RectorPrefix20201227\PHPStan\Rules\Methods\MissingMethodParameterTypehintRule;
use RectorPrefix20201227\PHPStan\Rules\Methods\MissingMethodReturnTypehintRule;
use RectorPrefix20201227\PHPStan\Rules\MissingTypehintCheck;
use RectorPrefix20201227\PHPStan\Rules\PhpDoc\IncompatiblePhpDocTypeRule;
use RectorPrefix20201227\PHPStan\Rules\PhpDoc\IncompatiblePropertyPhpDocTypeRule;
use RectorPrefix20201227\PHPStan\Rules\PhpDoc\InvalidPhpDocTagValueRule;
use RectorPrefix20201227\PHPStan\Rules\PhpDoc\InvalidThrowsPhpDocValueRule;
use RectorPrefix20201227\PHPStan\Rules\Properties\ExistingClassesInPropertiesRule;
use RectorPrefix20201227\PHPStan\Rules\Properties\MissingPropertyTypehintRule;
use RectorPrefix20201227\PHPStan\Rules\Registry;
use PHPStan\Type\FileTypeMapper;
class StubValidator
{
    /** @var \PHPStan\DependencyInjection\DerivativeContainerFactory */
    private $derivativeContainerFactory;
    public function __construct(\RectorPrefix20201227\PHPStan\DependencyInjection\DerivativeContainerFactory $derivativeContainerFactory)
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
        $originalBroker = \RectorPrefix20201227\PHPStan\Broker\Broker::getInstance();
        $container = $this->derivativeContainerFactory->create([__DIR__ . '/../../conf/config.stubValidator.neon']);
        $ruleRegistry = $this->getRuleRegistry($container);
        /** @var FileAnalyser $fileAnalyser */
        $fileAnalyser = $container->getByType(\RectorPrefix20201227\PHPStan\Analyser\FileAnalyser::class);
        /** @var NodeScopeResolver $nodeScopeResolver */
        $nodeScopeResolver = $container->getByType(\RectorPrefix20201227\PHPStan\Analyser\NodeScopeResolver::class);
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
        \RectorPrefix20201227\PHPStan\Broker\Broker::registerInstance($originalBroker);
        return $errors;
    }
    private function getRuleRegistry(\RectorPrefix20201227\PHPStan\DependencyInjection\Container $container) : \RectorPrefix20201227\PHPStan\Rules\Registry
    {
        $fileTypeMapper = $container->getByType(\PHPStan\Type\FileTypeMapper::class);
        $genericObjectTypeCheck = $container->getByType(\RectorPrefix20201227\PHPStan\Rules\Generics\GenericObjectTypeCheck::class);
        $genericAncestorsCheck = $container->getByType(\RectorPrefix20201227\PHPStan\Rules\Generics\GenericAncestorsCheck::class);
        $templateTypeCheck = $container->getByType(\RectorPrefix20201227\PHPStan\Rules\Generics\TemplateTypeCheck::class);
        $varianceCheck = $container->getByType(\RectorPrefix20201227\PHPStan\Rules\Generics\VarianceCheck::class);
        $reflectionProvider = $container->getByType(\RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider::class);
        $classCaseSensitivityCheck = $container->getByType(\RectorPrefix20201227\PHPStan\Rules\ClassCaseSensitivityCheck::class);
        $functionDefinitionCheck = $container->getByType(\RectorPrefix20201227\PHPStan\Rules\FunctionDefinitionCheck::class);
        $missingTypehintCheck = $container->getByType(\RectorPrefix20201227\PHPStan\Rules\MissingTypehintCheck::class);
        return new \RectorPrefix20201227\PHPStan\Rules\Registry([
            // level 0
            new \RectorPrefix20201227\PHPStan\Rules\Classes\ExistingClassesInClassImplementsRule($classCaseSensitivityCheck, $reflectionProvider),
            new \RectorPrefix20201227\PHPStan\Rules\Classes\ExistingClassesInInterfaceExtendsRule($classCaseSensitivityCheck, $reflectionProvider),
            new \RectorPrefix20201227\PHPStan\Rules\Classes\ExistingClassInClassExtendsRule($classCaseSensitivityCheck, $reflectionProvider),
            new \RectorPrefix20201227\PHPStan\Rules\Classes\ExistingClassInTraitUseRule($classCaseSensitivityCheck, $reflectionProvider),
            new \RectorPrefix20201227\PHPStan\Rules\Methods\ExistingClassesInTypehintsRule($functionDefinitionCheck),
            new \RectorPrefix20201227\PHPStan\Rules\Functions\ExistingClassesInTypehintsRule($functionDefinitionCheck),
            new \RectorPrefix20201227\PHPStan\Rules\Properties\ExistingClassesInPropertiesRule($reflectionProvider, $classCaseSensitivityCheck, \true, \false),
            // level 2
            new \RectorPrefix20201227\PHPStan\Rules\Generics\ClassAncestorsRule($fileTypeMapper, $genericAncestorsCheck),
            new \RectorPrefix20201227\PHPStan\Rules\Generics\ClassTemplateTypeRule($templateTypeCheck),
            new \RectorPrefix20201227\PHPStan\Rules\Generics\FunctionTemplateTypeRule($fileTypeMapper, $templateTypeCheck),
            new \RectorPrefix20201227\PHPStan\Rules\Generics\FunctionSignatureVarianceRule($varianceCheck),
            new \RectorPrefix20201227\PHPStan\Rules\Generics\InterfaceAncestorsRule($fileTypeMapper, $genericAncestorsCheck),
            new \RectorPrefix20201227\PHPStan\Rules\Generics\InterfaceTemplateTypeRule($fileTypeMapper, $templateTypeCheck),
            new \RectorPrefix20201227\PHPStan\Rules\Generics\MethodTemplateTypeRule($fileTypeMapper, $templateTypeCheck),
            new \RectorPrefix20201227\PHPStan\Rules\Generics\MethodSignatureVarianceRule($varianceCheck),
            new \RectorPrefix20201227\PHPStan\Rules\Generics\TraitTemplateTypeRule($fileTypeMapper, $templateTypeCheck),
            new \RectorPrefix20201227\PHPStan\Rules\PhpDoc\IncompatiblePhpDocTypeRule($fileTypeMapper, $genericObjectTypeCheck),
            new \RectorPrefix20201227\PHPStan\Rules\PhpDoc\IncompatiblePropertyPhpDocTypeRule($genericObjectTypeCheck),
            new \RectorPrefix20201227\PHPStan\Rules\PhpDoc\InvalidPhpDocTagValueRule($container->getByType(\RectorPrefix20201227\PHPStan\PhpDocParser\Lexer\Lexer::class), $container->getByType(\RectorPrefix20201227\PHPStan\PhpDocParser\Parser\PhpDocParser::class)),
            new \RectorPrefix20201227\PHPStan\Rules\PhpDoc\InvalidThrowsPhpDocValueRule($fileTypeMapper),
            // level 6
            new \RectorPrefix20201227\PHPStan\Rules\Functions\MissingFunctionParameterTypehintRule($missingTypehintCheck),
            new \RectorPrefix20201227\PHPStan\Rules\Functions\MissingFunctionReturnTypehintRule($missingTypehintCheck),
            new \RectorPrefix20201227\PHPStan\Rules\Methods\MissingMethodParameterTypehintRule($missingTypehintCheck),
            new \RectorPrefix20201227\PHPStan\Rules\Methods\MissingMethodReturnTypehintRule($missingTypehintCheck),
            new \RectorPrefix20201227\PHPStan\Rules\Properties\MissingPropertyTypehintRule($missingTypehintCheck),
        ]);
    }
}
