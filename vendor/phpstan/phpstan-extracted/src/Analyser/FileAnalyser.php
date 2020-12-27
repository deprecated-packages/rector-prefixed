<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Analyser;

use PhpParser\Comment;
use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Dependency\DependencyResolver;
use RectorPrefix20201227\PHPStan\Node\FileNode;
use RectorPrefix20201227\PHPStan\Parser\Parser;
use RectorPrefix20201227\PHPStan\Rules\FileRuleError;
use RectorPrefix20201227\PHPStan\Rules\IdentifierRuleError;
use RectorPrefix20201227\PHPStan\Rules\LineRuleError;
use RectorPrefix20201227\PHPStan\Rules\MetadataRuleError;
use RectorPrefix20201227\PHPStan\Rules\NonIgnorableRuleError;
use RectorPrefix20201227\PHPStan\Rules\Registry;
use RectorPrefix20201227\PHPStan\Rules\TipRuleError;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\Exception\UnableToCompileNode;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAClassReflection;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAnInterfaceReflection;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
use function array_fill_keys;
use function array_key_exists;
use function array_unique;
class FileAnalyser
{
    /** @var \PHPStan\Analyser\ScopeFactory */
    private $scopeFactory;
    /** @var \PHPStan\Analyser\NodeScopeResolver */
    private $nodeScopeResolver;
    /** @var \PHPStan\Parser\Parser */
    private $parser;
    /** @var DependencyResolver */
    private $dependencyResolver;
    /** @var bool */
    private $reportUnmatchedIgnoredErrors;
    public function __construct(\RectorPrefix20201227\PHPStan\Analyser\ScopeFactory $scopeFactory, \RectorPrefix20201227\PHPStan\Analyser\NodeScopeResolver $nodeScopeResolver, \RectorPrefix20201227\PHPStan\Parser\Parser $parser, \RectorPrefix20201227\PHPStan\Dependency\DependencyResolver $dependencyResolver, bool $reportUnmatchedIgnoredErrors)
    {
        $this->scopeFactory = $scopeFactory;
        $this->nodeScopeResolver = $nodeScopeResolver;
        $this->parser = $parser;
        $this->dependencyResolver = $dependencyResolver;
        $this->reportUnmatchedIgnoredErrors = $reportUnmatchedIgnoredErrors;
    }
    /**
     * @param string $file
     * @param array<string, true> $analysedFiles
     * @param Registry $registry
     * @param callable(\PhpParser\Node $node, Scope $scope): void|null $outerNodeCallback
     * @return FileAnalyserResult
     */
    public function analyseFile(string $file, array $analysedFiles, \RectorPrefix20201227\PHPStan\Rules\Registry $registry, ?callable $outerNodeCallback) : \RectorPrefix20201227\PHPStan\Analyser\FileAnalyserResult
    {
        $fileErrors = [];
        $fileDependencies = [];
        $exportedNodes = [];
        if (\is_file($file)) {
            try {
                $parserNodes = $this->parser->parseFile($file);
                $linesToIgnore = [];
                $temporaryFileErrors = [];
                $nodeCallback = function (\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) use(&$fileErrors, &$fileDependencies, &$exportedNodes, $file, $registry, $outerNodeCallback, $analysedFiles, &$linesToIgnore, &$temporaryFileErrors) : void {
                    if ($outerNodeCallback !== null) {
                        $outerNodeCallback($node, $scope);
                    }
                    $uniquedAnalysedCodeExceptionMessages = [];
                    $nodeType = \get_class($node);
                    foreach ($registry->getRules($nodeType) as $rule) {
                        try {
                            $ruleErrors = $rule->processNode($node, $scope);
                        } catch (\RectorPrefix20201227\PHPStan\AnalysedCodeException $e) {
                            if (isset($uniquedAnalysedCodeExceptionMessages[$e->getMessage()])) {
                                continue;
                            }
                            $uniquedAnalysedCodeExceptionMessages[$e->getMessage()] = \true;
                            $fileErrors[] = new \RectorPrefix20201227\PHPStan\Analyser\Error($e->getMessage(), $file, $node->getLine(), $e, null, null, $e->getTip());
                            continue;
                        } catch (\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
                            $fileErrors[] = new \RectorPrefix20201227\PHPStan\Analyser\Error(\sprintf('Reflection error: %s not found.', $e->getIdentifier()->getName()), $file, $node->getLine(), $e, null, null, 'Learn more at https://phpstan.org/user-guide/discovering-symbols');
                            continue;
                        } catch (\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\Exception\UnableToCompileNode|\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAClassReflection|\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAnInterfaceReflection $e) {
                            $fileErrors[] = new \RectorPrefix20201227\PHPStan\Analyser\Error(\sprintf('Reflection error: %s', $e->getMessage()), $file, $node->getLine(), $e);
                            continue;
                        }
                        foreach ($ruleErrors as $ruleError) {
                            $nodeLine = $node->getLine();
                            $line = $nodeLine;
                            $canBeIgnored = \true;
                            $fileName = $scope->getFileDescription();
                            $filePath = $scope->getFile();
                            $traitFilePath = null;
                            $tip = null;
                            $identifier = null;
                            $metadata = [];
                            if ($scope->isInTrait()) {
                                $traitReflection = $scope->getTraitReflection();
                                if ($traitReflection->getFileName() !== \false) {
                                    $traitFilePath = $traitReflection->getFileName();
                                }
                            }
                            if (\is_string($ruleError)) {
                                $message = $ruleError;
                            } else {
                                $message = $ruleError->getMessage();
                                if ($ruleError instanceof \RectorPrefix20201227\PHPStan\Rules\LineRuleError && $ruleError->getLine() !== -1) {
                                    $line = $ruleError->getLine();
                                }
                                if ($ruleError instanceof \RectorPrefix20201227\PHPStan\Rules\FileRuleError && $ruleError->getFile() !== '') {
                                    $fileName = $ruleError->getFile();
                                    $filePath = $ruleError->getFile();
                                    $traitFilePath = null;
                                }
                                if ($ruleError instanceof \RectorPrefix20201227\PHPStan\Rules\TipRuleError) {
                                    $tip = $ruleError->getTip();
                                }
                                if ($ruleError instanceof \RectorPrefix20201227\PHPStan\Rules\IdentifierRuleError) {
                                    $identifier = $ruleError->getIdentifier();
                                }
                                if ($ruleError instanceof \RectorPrefix20201227\PHPStan\Rules\MetadataRuleError) {
                                    $metadata = $ruleError->getMetadata();
                                }
                                if ($ruleError instanceof \RectorPrefix20201227\PHPStan\Rules\NonIgnorableRuleError) {
                                    $canBeIgnored = \false;
                                }
                            }
                            $temporaryFileErrors[] = new \RectorPrefix20201227\PHPStan\Analyser\Error($message, $fileName, $line, $canBeIgnored, $filePath, $traitFilePath, $tip, $nodeLine, $nodeType, $identifier, $metadata);
                        }
                    }
                    foreach ($this->getLinesToIgnore($node) as $lineToIgnore) {
                        $linesToIgnore[] = $lineToIgnore;
                    }
                    try {
                        $dependencies = $this->dependencyResolver->resolveDependencies($node, $scope);
                        foreach ($dependencies->getFileDependencies($scope->getFile(), $analysedFiles) as $dependentFile) {
                            $fileDependencies[] = $dependentFile;
                        }
                        if ($dependencies->getExportedNode() !== null) {
                            $exportedNodes[] = $dependencies->getExportedNode();
                        }
                    } catch (\RectorPrefix20201227\PHPStan\AnalysedCodeException $e) {
                        // pass
                    } catch (\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
                        // pass
                    } catch (\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\Exception\UnableToCompileNode|\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAClassReflection|\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAnInterfaceReflection $e) {
                        // pass
                    }
                };
                $scope = $this->scopeFactory->create(\RectorPrefix20201227\PHPStan\Analyser\ScopeContext::create($file));
                $nodeCallback(new \RectorPrefix20201227\PHPStan\Node\FileNode($parserNodes), $scope);
                $this->nodeScopeResolver->processNodes($parserNodes, $scope, $nodeCallback);
                $linesToIgnoreKeys = \array_fill_keys($linesToIgnore, \true);
                $unmatchedLineIgnores = $linesToIgnoreKeys;
                foreach ($temporaryFileErrors as $tmpFileError) {
                    $line = $tmpFileError->getLine();
                    if ($line !== null && $tmpFileError->canBeIgnored() && \array_key_exists($line, $linesToIgnoreKeys)) {
                        unset($unmatchedLineIgnores[$line]);
                        continue;
                    }
                    $fileErrors[] = $tmpFileError;
                }
                if ($this->reportUnmatchedIgnoredErrors) {
                    foreach (\array_keys($unmatchedLineIgnores) as $line) {
                        $traitFilePath = null;
                        if ($scope->isInTrait()) {
                            $traitReflection = $scope->getTraitReflection();
                            if ($traitReflection->getFileName() !== \false) {
                                $traitFilePath = $traitReflection->getFileName();
                            }
                        }
                        $fileErrors[] = new \RectorPrefix20201227\PHPStan\Analyser\Error(\sprintf('No error to ignore is reported on line %d.', $line), $scope->getFileDescription(), $line, \false, $scope->getFile(), $traitFilePath, null, null, null, 'ignoredError.unmatchedOnLine');
                    }
                }
            } catch (\PhpParser\Error $e) {
                $fileErrors[] = new \RectorPrefix20201227\PHPStan\Analyser\Error($e->getMessage(), $file, $e->getStartLine() !== -1 ? $e->getStartLine() : null, $e);
            } catch (\RectorPrefix20201227\PHPStan\Parser\ParserErrorsException $e) {
                foreach ($e->getErrors() as $error) {
                    $fileErrors[] = new \RectorPrefix20201227\PHPStan\Analyser\Error($error->getMessage(), $e->getParsedFile() ?? $file, $error->getStartLine() !== -1 ? $error->getStartLine() : null, $e);
                }
            } catch (\RectorPrefix20201227\PHPStan\AnalysedCodeException $e) {
                $fileErrors[] = new \RectorPrefix20201227\PHPStan\Analyser\Error($e->getMessage(), $file, null, $e, null, null, $e->getTip());
            } catch (\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
                $fileErrors[] = new \RectorPrefix20201227\PHPStan\Analyser\Error(\sprintf('Reflection error: %s not found.', $e->getIdentifier()->getName()), $file, null, $e, null, null, 'Learn more at https://phpstan.org/user-guide/discovering-symbols');
            } catch (\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\Exception\UnableToCompileNode|\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAClassReflection|\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAnInterfaceReflection $e) {
                $fileErrors[] = new \RectorPrefix20201227\PHPStan\Analyser\Error(\sprintf('Reflection error: %s', $e->getMessage()), $file, null, $e);
            }
        } elseif (\is_dir($file)) {
            $fileErrors[] = new \RectorPrefix20201227\PHPStan\Analyser\Error(\sprintf('File %s is a directory.', $file), $file, null, \false);
        } else {
            $fileErrors[] = new \RectorPrefix20201227\PHPStan\Analyser\Error(\sprintf('File %s does not exist.', $file), $file, null, \false);
        }
        return new \RectorPrefix20201227\PHPStan\Analyser\FileAnalyserResult($fileErrors, \array_values(\array_unique($fileDependencies)), $exportedNodes);
    }
    /**
     * @param Node $node
     * @return int[]
     */
    private function getLinesToIgnore(\PhpParser\Node $node) : array
    {
        $lines = [];
        if ($node->getDocComment() !== null) {
            $line = $this->findLineToIgnoreComment($node->getDocComment());
            if ($line !== null) {
                $lines[] = $line;
            }
        }
        foreach ($node->getComments() as $comment) {
            $line = $this->findLineToIgnoreComment($comment);
            if ($line === null) {
                continue;
            }
            $lines[] = $line;
        }
        return $lines;
    }
    private function findLineToIgnoreComment(\PhpParser\Comment $comment) : ?int
    {
        $text = $comment->getText();
        if ($comment instanceof \PhpParser\Comment\Doc) {
            $line = $comment->getEndLine();
        } else {
            if (\strpos($text, "\n") === \false || \strpos($text, '//') === 0) {
                $line = $comment->getStartLine();
            } else {
                $line = $comment->getEndLine();
            }
        }
        if (\strpos($text, '@phpstan-ignore-next-line') !== \false) {
            return $line + 1;
        }
        if (\strpos($text, '@phpstan-ignore-line') !== \false) {
            return $line;
        }
        return null;
    }
}
