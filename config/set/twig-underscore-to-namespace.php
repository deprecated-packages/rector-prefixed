<?php

declare (strict_types=1);
namespace _PhpScoper5edc98a7cce2;

use Rector\Generic\ValueObject\PseudoNamespaceToNamespace;
use Rector\Renaming\Rector\FileWithoutNamespace\PseudoNamespaceToNamespaceRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['Twig_LoaderInterface' => '_PhpScoper5edc98a7cce2\\Twig\\Loader\\LoaderInterface', 'Twig_Extension_StringLoader' => '_PhpScoper5edc98a7cce2\\Twig\\Extension\\StringLoaderExtension', 'Twig_Extension_Optimizer' => '_PhpScoper5edc98a7cce2\\Twig\\Extension\\OptimizerExtension', 'Twig_Extension_Debug' => '_PhpScoper5edc98a7cce2\\Twig\\Extension\\DebugExtension', 'Twig_Extension_Sandbox' => '_PhpScoper5edc98a7cce2\\Twig\\Extension\\SandboxExtension', 'Twig_Extension_Profiler' => '_PhpScoper5edc98a7cce2\\Twig\\Extension\\ProfilerExtension', 'Twig_Extension_Escaper' => '_PhpScoper5edc98a7cce2\\Twig\\Extension\\EscaperExtension', 'Twig_Extension_Staging' => '_PhpScoper5edc98a7cce2\\Twig\\Extension\\StagingExtension', 'Twig_Extension_Core' => '_PhpScoper5edc98a7cce2\\Twig\\Extension\\CoreExtension', 'Twig_Node' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Node', 'Twig_NodeVisitor_Optimizer' => '_PhpScoper5edc98a7cce2\\Twig\\NodeVisitor\\OptimizerNodeVisitor', 'Twig_NodeVisitor_SafeAnalysis' => '_PhpScoper5edc98a7cce2\\Twig\\NodeVisitor\\SafeAnalysisNodeVisitor', 'Twig_NodeVisitor_Sandbox' => '_PhpScoper5edc98a7cce2\\Twig\\NodeVisitor\\SandboxNodeVisitor', 'Twig_NodeVisitor_Escaper' => '_PhpScoper5edc98a7cce2\\Twig\\NodeVisitor\\EscaperNodeVisitor', 'Twig_SimpleFunction' => '_PhpScoper5edc98a7cce2\\Twig\\TwigFunction', 'Twig_Function' => '_PhpScoper5edc98a7cce2\\Twig\\TwigFunction', 'Twig_Error_Syntax' => '_PhpScoper5edc98a7cce2\\Twig\\Error\\SyntaxError', 'Twig_Error_Loader' => '_PhpScoper5edc98a7cce2\\Twig\\Error\\LoaderError', 'Twig_Error_Runtime' => '_PhpScoper5edc98a7cce2\\Twig\\Error\\RuntimeError', 'Twig_TokenParser' => '_PhpScoper5edc98a7cce2\\Twig\\TokenParser\\AbstractTokenParser', 'Twig_TokenParserInterface' => '_PhpScoper5edc98a7cce2\\Twig\\TokenParser\\TokenParserInterface', 'Twig_CacheInterface' => '_PhpScoper5edc98a7cce2\\Twig\\Cache\\CacheInterface', 'Twig_NodeVisitorInterface' => '_PhpScoper5edc98a7cce2\\Twig\\NodeVisitor\\NodeVisitorInterface', 'Twig_Profiler_NodeVisitor_Profiler' => '_PhpScoper5edc98a7cce2\\Twig\\Profiler\\NodeVisitor\\ProfilerNodeVisitor', 'Twig_Profiler_Dumper_Text' => '_PhpScoper5edc98a7cce2\\Twig\\Profiler\\Dumper\\TextDumper', 'Twig_Profiler_Dumper_Base' => '_PhpScoper5edc98a7cce2\\Twig\\Profiler\\Dumper\\BaseDumper', 'Twig_Profiler_Dumper_Blackfire' => '_PhpScoper5edc98a7cce2\\Twig\\Profiler\\Dumper\\BlackfireDumper', 'Twig_Profiler_Dumper_Html' => '_PhpScoper5edc98a7cce2\\Twig\\Profiler\\Dumper\\HtmlDumper', 'Twig_Profiler_Node_LeaveProfile' => '_PhpScoper5edc98a7cce2\\Twig\\Profiler\\Node\\LeaveProfileNode', 'Twig_Profiler_Node_EnterProfile' => '_PhpScoper5edc98a7cce2\\Twig\\Profiler\\Node\\EnterProfileNode', 'Twig_Error' => '_PhpScoper5edc98a7cce2\\Twig\\Error\\Error', 'Twig_ExistsLoaderInterface' => '_PhpScoper5edc98a7cce2\\Twig\\Loader\\ExistsLoaderInterface', 'Twig_SimpleTest' => '_PhpScoper5edc98a7cce2\\Twig\\TwigTest', 'Twig_Test' => '_PhpScoper5edc98a7cce2\\Twig\\TwigTest', 'Twig_FactoryRuntimeLoader' => '_PhpScoper5edc98a7cce2\\Twig\\RuntimeLoader\\FactoryRuntimeLoader', 'Twig_NodeOutputInterface' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\NodeOutputInterface', 'Twig_SimpleFilter' => '_PhpScoper5edc98a7cce2\\Twig\\TwigFilter', 'Twig_Filter' => '_PhpScoper5edc98a7cce2\\Twig\\TwigFilter', 'Twig_Loader_Chain' => '_PhpScoper5edc98a7cce2\\Twig\\Loader\\ChainLoader', 'Twig_Loader_Array' => '_PhpScoper5edc98a7cce2\\Twig\\Loader\\ArrayLoader', 'Twig_Loader_Filesystem' => '_PhpScoper5edc98a7cce2\\Twig\\Loader\\FilesystemLoader', 'Twig_Cache_Null' => '_PhpScoper5edc98a7cce2\\Twig\\Cache\\NullCache', 'Twig_Cache_Filesystem' => '_PhpScoper5edc98a7cce2\\Twig\\Cache\\FilesystemCache', 'Twig_NodeCaptureInterface' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\NodeCaptureInterface', 'Twig_Extension' => '_PhpScoper5edc98a7cce2\\Twig\\Extension\\AbstractExtension', 'Twig_TokenParser_Macro' => '_PhpScoper5edc98a7cce2\\Twig\\TokenParser\\MacroTokenParser', 'Twig_TokenParser_Embed' => '_PhpScoper5edc98a7cce2\\Twig\\TokenParser\\EmbedTokenParser', 'Twig_TokenParser_Do' => '_PhpScoper5edc98a7cce2\\Twig\\TokenParser\\DoTokenParser', 'Twig_TokenParser_From' => '_PhpScoper5edc98a7cce2\\Twig\\TokenParser\\FromTokenParser', 'Twig_TokenParser_Extends' => '_PhpScoper5edc98a7cce2\\Twig\\TokenParser\\ExtendsTokenParser', 'Twig_TokenParser_Set' => '_PhpScoper5edc98a7cce2\\Twig\\TokenParser\\SetTokenParser', 'Twig_TokenParser_Sandbox' => '_PhpScoper5edc98a7cce2\\Twig\\TokenParser\\SandboxTokenParser', 'Twig_TokenParser_AutoEscape' => '_PhpScoper5edc98a7cce2\\Twig\\TokenParser\\AutoEscapeTokenParser', 'Twig_TokenParser_With' => '_PhpScoper5edc98a7cce2\\Twig\\TokenParser\\WithTokenParser', 'Twig_TokenParser_Include' => '_PhpScoper5edc98a7cce2\\Twig\\TokenParser\\IncludeTokenParser', 'Twig_TokenParser_Block' => '_PhpScoper5edc98a7cce2\\Twig\\TokenParser\\BlockTokenParser', 'Twig_TokenParser_Filter' => '_PhpScoper5edc98a7cce2\\Twig\\TokenParser\\FilterTokenParser', 'Twig_TokenParser_If' => '_PhpScoper5edc98a7cce2\\Twig\\TokenParser\\IfTokenParser', 'Twig_TokenParser_For' => '_PhpScoper5edc98a7cce2\\Twig\\TokenParser\\ForTokenParser', 'Twig_TokenParser_Flush' => '_PhpScoper5edc98a7cce2\\Twig\\TokenParser\\FlushTokenParser', 'Twig_TokenParser_Spaceless' => '_PhpScoper5edc98a7cce2\\Twig\\TokenParser\\SpacelessTokenParser', 'Twig_TokenParser_Use' => '_PhpScoper5edc98a7cce2\\Twig\\TokenParser\\UseTokenParser', 'Twig_TokenParser_Import' => '_PhpScoper5edc98a7cce2\\Twig\\TokenParser\\ImportTokenParser', 'Twig_ContainerRuntimeLoader' => '_PhpScoper5edc98a7cce2\\Twig\\RuntimeLoader\\ContainerRuntimeLoader', 'Twig_SourceContextLoaderInterface' => '_PhpScoper5edc98a7cce2\\Twig\\Loader\\SourceContextLoaderInterface', 'Twig_NodeTraverser' => '_PhpScoper5edc98a7cce2\\Twig\\NodeTraverser', 'Twig_ExtensionInterface' => '_PhpScoper5edc98a7cce2\\Twig\\Extension\\ExtensionInterface', 'Twig_Node_Macro' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\MacroNode', 'Twig_Node_Embed' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\EmbedNode', 'Twig_Node_Do' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\DoNode', 'Twig_Node_Text' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\TextNode', 'Twig_Node_Set' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\SetNode', 'Twig_Node_Sandbox' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\SandboxNode', 'Twig_Node_AutoEscape' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\AutoEscapeNode', 'Twig_Node_With' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\WithNode', 'Twig_Node_Include' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\IncludeNode', 'Twig_Node_Print' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\PrintNode', 'Twig_Node_Block' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\BlockNode', 'Twig_Node_Expression_MethodCall' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\MethodCallExpression', 'Twig_Node_Expression_Unary_Pos' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Unary\\PosUnary', 'Twig_Node_Expression_Unary_Not' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Unary\\NotUnary', 'Twig_Node_Expression_Unary_Neg' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Unary\\NegUnary', 'Twig_Node_Expression_GetAttr' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\GetAttrExpression', 'Twig_Node_Expression_Function' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\FunctionExpression', 'Twig_Node_Expression_Binary_Power' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Binary\\PowerBinary', 'Twig_Node_Expression_Binary_In' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Binary\\InBinary', 'Twig_Node_Expression_Binary_BitwiseXor' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Binary\\BitwiseXorBinary', 'Twig_Node_Expression_Binary_Concat' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Binary\\ConcatBinary', 'Twig_Node_Expression_Binary_NotEqual' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Binary\\NotEqualBinary', 'Twig_Node_Expression_Binary_Less' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Binary\\LessBinary', 'Twig_Node_Expression_Binary_And' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Binary\\AndBinary', 'Twig_Node_Expression_Binary_GreaterEqual' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Binary\\GreaterEqualBinary', 'Twig_Node_Expression_Binary_Mod' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Binary\\ModBinary', 'Twig_Node_Expression_Binary_NotIn' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Binary\\NotInBinary', 'Twig_Node_Expression_Binary_Add' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Binary\\AddBinary', 'Twig_Node_Expression_Binary_Matches' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Binary\\MatchesBinary', 'Twig_Node_Expression_Binary_EndsWith' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Binary\\EndsWithBinary', 'Twig_Node_Expression_Binary_FloorDiv' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Binary\\FloorDivBinary', 'Twig_Node_Expression_Binary_StartsWith' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Binary\\StartsWithBinary', 'Twig_Node_Expression_Binary_LessEqual' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Binary\\LessEqualBinary', 'Twig_Node_Expression_Binary_Equal' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Binary\\EqualBinary', 'Twig_Node_Expression_Binary_BitwiseAnd' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Binary\\BitwiseAndBinary', 'Twig_Node_Expression_Binary_Mul' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Binary\\MulBinary', 'Twig_Node_Expression_Binary_Range' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Binary\\RangeBinary', 'Twig_Node_Expression_Binary_Or' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Binary\\OrBinary', 'Twig_Node_Expression_Binary_Greater' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Binary\\GreaterBinary', 'Twig_Node_Expression_Binary_Div' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Binary\\DivBinary', 'Twig_Node_Expression_Binary_BitwiseOr' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Binary\\BitwiseOrBinary', 'Twig_Node_Expression_Binary_Sub' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Binary\\SubBinary', 'Twig_Node_Expression_Test_Even' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Test\\EvenTest', 'Twig_Node_Expression_Test_Defined' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Test\\DefinedTest', 'Twig_Node_Expression_Test_Sameas' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Test\\SameasTest', 'Twig_Node_Expression_Test_Odd' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Test\\OddTest', 'Twig_Node_Expression_Test_Constant' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Test\\ConstantTest', 'Twig_Node_Expression_Test_Null' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Test\\NullTest', 'Twig_Node_Expression_Test_Divisibleby' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Test\\DivisiblebyTest', 'Twig_Node_Expression_Array' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\ArrayExpression', 'Twig_Node_Expression_Binary' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Binary\\AbstractBinary', 'Twig_Node_Expression_Constant' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\ConstantExpression', 'Twig_Node_Expression_Parent' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\ParentExpression', 'Twig_Node_Expression_Test' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\TestExpression', 'Twig_Node_Expression_Filter_Default' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Filter\\DefaultFilter', 'Twig_Node_Expression_Filter' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\FilterExpression', 'Twig_Node_Expression_BlockReference' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\BlockReferenceExpression', 'Twig_Node_Expression_NullCoalesce' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\NullCoalesceExpression', 'Twig_Node_Expression_Name' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\NameExpression', 'Twig_Node_Expression_TempName' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\TempNameExpression', 'Twig_Node_Expression_Call' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\CallExpression', 'Twig_Node_Expression_Unary' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\Unary\\AbstractUnary', 'Twig_Node_Expression_AssignName' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\AssignNameExpression', 'Twig_Node_Expression_Conditional' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\ConditionalExpression', 'Twig_Node_CheckSecurity' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\CheckSecurityNode', 'Twig_Node_Expression' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\Expression\\AbstractExpression', 'Twig_Node_ForLoop' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\ForLoopNode', 'Twig_Node_If' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\IfNode', 'Twig_Node_For' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\ForNode', 'Twig_Node_BlockReference' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\BlockReferenceNode', 'Twig_Node_Flush' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\FlushNode', 'Twig_Node_Body' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\BodyNode', 'Twig_Node_Spaceless' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\SpacelessNode', 'Twig_Node_Import' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\ImportNode', 'Twig_Node_SandboxedPrint' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\SandboxedPrintNode', 'Twig_Node_Module' => '_PhpScoper5edc98a7cce2\\Twig\\Node\\ModuleNode', 'Twig_RuntimeLoaderInterface' => '_PhpScoper5edc98a7cce2\\Twig\\RuntimeLoader\\RuntimeLoaderInterface', 'Twig_BaseNodeVisitor' => '_PhpScoper5edc98a7cce2\\Twig\\NodeVisitor\\AbstractNodeVisitor', 'Twig_Extensions_Extension_Text' => '_PhpScoper5edc98a7cce2\\Twig\\Extensions\\TextExtension', 'Twig_Extensions_Extension_Array' => '_PhpScoper5edc98a7cce2\\Twig\\Extensions\\ArrayExtension', 'Twig_Extensions_Extension_Date' => '_PhpScoper5edc98a7cce2\\Twig\\Extensions\\DateExtension', 'Twig_Extensions_Extension_I18n' => '_PhpScoper5edc98a7cce2\\Twig\\Extensions\\I18nExtension', 'Twig_Extensions_Extension_Intl' => '_PhpScoper5edc98a7cce2\\Twig\\Extensions\\IntlExtension', 'Twig_Extensions_TokenParser_Trans' => '_PhpScoper5edc98a7cce2\\Twig\\Extensions\\TokenParser\\TransTokenParser', 'Twig_Extensions_Node_Trans' => '_PhpScoper5edc98a7cce2\\Twig\\Extensions\\Node\\TransNode']]]);
    $services->set(\Rector\Renaming\Rector\FileWithoutNamespace\PseudoNamespaceToNamespaceRector::class)->call('configure', [[\Rector\Renaming\Rector\FileWithoutNamespace\PseudoNamespaceToNamespaceRector::NAMESPACE_PREFIXES_WITH_EXCLUDED_CLASSES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\PseudoNamespaceToNamespace('Twig_')])]]);
};
