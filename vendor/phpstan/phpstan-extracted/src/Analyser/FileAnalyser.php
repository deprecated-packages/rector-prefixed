<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Analyser;

use _PhpScoper0a6b37af0871\PhpParser\Comment;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Dependency\DependencyResolver;
use _PhpScoper0a6b37af0871\PHPStan\Node\FileNode;
use _PhpScoper0a6b37af0871\PHPStan\Parser\Parser;
use _PhpScoper0a6b37af0871\PHPStan\Rules\FileRuleError;
use _PhpScoper0a6b37af0871\PHPStan\Rules\IdentifierRuleError;
use _PhpScoper0a6b37af0871\PHPStan\Rules\LineRuleError;
use _PhpScoper0a6b37af0871\PHPStan\Rules\MetadataRuleError;
use _PhpScoper0a6b37af0871\PHPStan\Rules\NonIgnorableRuleError;
use _PhpScoper0a6b37af0871\PHPStan\Rules\Registry;
use _PhpScoper0a6b37af0871\PHPStan\Rules\TipRuleError;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\Exception\UnableToCompileNode;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAClassReflection;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAnInterfaceReflection;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
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
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Analyser\ScopeFactory $scopeFactory, \_PhpScoper0a6b37af0871\PHPStan\Analyser\NodeScopeResolver $nodeScopeResolver, \_PhpScoper0a6b37af0871\PHPStan\Parser\Parser $parser, \_PhpScoper0a6b37af0871\PHPStan\Dependency\DependencyResolver $dependencyResolver, bool $reportUnmatchedIgnoredErrors)
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
    public function analyseFile(string $file, array $analysedFiles, \_PhpScoper0a6b37af0871\PHPStan\Rules\Registry $registry, ?callable $outerNodeCallback) : \_PhpScoper0a6b37af0871\PHPStan\Analyser\FileAnalyserResult
    {
        $fileErrors = [];
        $fileDependencies = [];
        $exportedNodes = [];
        if (\is_file($file)) {
            try {
                $parserNodes = $this->parser->parseFile($file);
                $linesToIgnore = [];
                $temporaryFileErrors = [];
                $nodeCallback = function (\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) use(&$fileErrors, &$fileDependencies, &$exportedNodes, $file, $registry, $outerNodeCallback, $analysedFiles, &$linesToIgnore, &$temporaryFileErrors) : void {
                    if ($outerNodeCallback !== null) {
                        $outerNodeCallback($node, $scope);
                    }
                    $uniquedAnalysedCodeExceptionMessages = [];
                    $nodeType = \get_class($node);
                    foreach ($registry->getRules($nodeType) as $rule) {
                        try {
                            $ruleErrors = $rule->processNode($node, $scope);
                        } catch (\_PhpScoper0a6b37af0871\PHPStan\AnalysedCodeException $e) {
                            if (isset($uniquedAnalysedCodeExceptionMessages[$e->getMessage()])) {
                                continue;
                            }
                            $uniquedAnalysedCodeExceptionMessages[$e->getMessage()] = \true;
                            $fileErrors[] = new \_PhpScoper0a6b37af0871\PHPStan\Analyser\Error($e->getMessage(), $file, $node->getLine(), $e, null, null, $e->getTip());
                            continue;
                        } catch (\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
                            $fileErrors[] = new \_PhpScoper0a6b37af0871\PHPStan\Analyser\Error(\sprintf('Reflection error: %s not found.', $e->getIdentifier()->getName()), $file, $node->getLine(), $e, null, null, 'Learn more at https://phpstan.org/user-guide/discovering-symbols');
                            continue;
                        } catch (\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\Exception\UnableToCompileNode|\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAClassReflection|\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAnInterfaceReflection $e) {
                            $fileErrors[] = new \_PhpScoper0a6b37af0871\PHPStan\Analyser\Error(\sprintf('Reflection error: %s', $e->getMessage()), $file, $node->getLine(), $e);
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
                                if ($ruleError instanceof \_PhpScoper0a6b37af0871\PHPStan\Rules\LineRuleError && $ruleError->getLine() !== -1) {
                                    $line = $ruleError->getLine();
                                }
                                if ($ruleError instanceof \_PhpScoper0a6b37af0871\PHPStan\Rules\FileRuleError && $ruleError->getFile() !== '') {
                                    $fileName = $ruleError->getFile();
                                    $filePath = $ruleError->getFile();
                                    $traitFilePath = null;
                                }
                                if ($ruleError instanceof \_PhpScoper0a6b37af0871\PHPStan\Rules\TipRuleError) {
                                    $tip = $ruleError->getTip();
                                }
                                if ($ruleError instanceof \_PhpScoper0a6b37af0871\PHPStan\Rules\IdentifierRuleError) {
                                    $identifier = $ruleError->getIdentifier();
                                }
                                if ($ruleError instanceof \_PhpScoper0a6b37af0871\PHPStan\Rules\MetadataRuleError) {
                                    $metadata = $ruleError->getMetadata();
                                }
                                if ($ruleError instanceof \_PhpScoper0a6b37af0871\PHPStan\Rules\NonIgnorableRuleError) {
                                    $canBeIgnored = \false;
                                }
                            }
                            $temporaryFileErrors[] = new \_PhpScoper0a6b37af0871\PHPStan\Analyser\Error($message, $fileName, $line, $canBeIgnored, $filePath, $traitFilePath, $tip, $nodeLine, $nodeType, $identifier, $metadata);
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
                    } catch (\_PhpScoper0a6b37af0871\PHPStan\AnalysedCodeException $e) {
                        // pass
                    } catch (\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
                        // pass
                    } catch (\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\Exception\UnableToCompileNode|\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAClassReflection|\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAnInterfaceReflection $e) {
                        // pass
                    }
                };
                $scope = $this->scopeFactory->create(\_PhpScoper0a6b37af0871\PHPStan\Analyser\ScopeContext::create($file));
                $nodeCallback(new \_PhpScoper0a6b37af0871\PHPStan\Node\FileNode($parserNodes), $scope);
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
                        $fileErrors[] = new \_PhpScoper0a6b37af0871\PHPStan\Analyser\Error(\sprintf('No error to ignore is reported on line %d.', $line), $scope->getFileDescription(), $line, \false, $scope->getFile(), $traitFilePath, null, null, null, 'ignoredError.unmatchedOnLine');
                    }
                }
            } catch (\_PhpScoper0a6b37af0871\PhpParser\Error $e) {
                $fileErrors[] = new \_PhpScoper0a6b37af0871\PHPStan\Analyser\Error($e->getMessage(), $file, $e->getStartLine() !== -1 ? $e->getStartLine() : null, $e);
            } catch (\_PhpScoper0a6b37af0871\PHPStan\Parser\ParserErrorsException $e) {
                foreach ($e->getErrors() as $error) {
                    $fileErrors[] = new \_PhpScoper0a6b37af0871\PHPStan\Analyser\Error($error->getMessage(), $e->getParsedFile() ?? $file, $error->getStartLine() !== -1 ? $error->getStartLine() : null, $e);
                }
            } catch (\_PhpScoper0a6b37af0871\PHPStan\AnalysedCodeException $e) {
                $fileErrors[] = new \_PhpScoper0a6b37af0871\PHPStan\Analyser\Error($e->getMessage(), $file, null, $e, null, null, $e->getTip());
            } catch (\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound $e) {
                $fileErrors[] = new \_PhpScoper0a6b37af0871\PHPStan\Analyser\Error(\sprintf('Reflection error: %s not found.', $e->getIdentifier()->getName()), $file, null, $e, null, null, 'Learn more at https://phpstan.org/user-guide/discovering-symbols');
            } catch (\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\NodeCompiler\Exception\UnableToCompileNode|\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAClassReflection|\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\NotAnInterfaceReflection $e) {
                $fileErrors[] = new \_PhpScoper0a6b37af0871\PHPStan\Analyser\Error(\sprintf('Reflection error: %s', $e->getMessage()), $file, null, $e);
            }
        } elseif (\is_dir($file)) {
            $fileErrors[] = new \_PhpScoper0a6b37af0871\PHPStan\Analyser\Error(\sprintf('File %s is a directory.', $file), $file, null, \false);
        } else {
            $fileErrors[] = new \_PhpScoper0a6b37af0871\PHPStan\Analyser\Error(\sprintf('File %s does not exist.', $file), $file, null, \false);
        }
        return new \_PhpScoper0a6b37af0871\PHPStan\Analyser\FileAnalyserResult($fileErrors, \array_values(\array_unique($fileDependencies)), $exportedNodes);
    }
    /**
     * @param Node $node
     * @return int[]
     */
    private function getLinesToIgnore(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : array
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
    private function findLineToIgnoreComment(\_PhpScoper0a6b37af0871\PhpParser\Comment $comment) : ?int
    {
        $text = $comment->getText();
        if ($comment instanceof \_PhpScoper0a6b37af0871\PhpParser\Comment\Doc) {
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
