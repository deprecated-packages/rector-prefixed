<?php

declare (strict_types=1);
namespace Rector\FileFormatter;

use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\Application\File;
use Rector\FileFormatter\Contract\EditorConfig\EditorConfigParserInterface;
use Rector\FileFormatter\Contract\Formatter\FileFormatterInterface;
use Rector\FileFormatter\Exception\InvalidNewLineStringException;
use Rector\FileFormatter\Exception\ParseIndentException;
use Rector\FileFormatter\ValueObject\EditorConfigConfiguration;
use Rector\FileFormatter\ValueObject\Indent;
use Rector\FileFormatter\ValueObject\NewLine;
use Rector\FileFormatter\ValueObjectFactory\EditorConfigConfigurationBuilder;
use RectorPrefix20210508\Symplify\PackageBuilder\Parameter\ParameterProvider;
final class FileFormatter
{
    /**
     * @var EditorConfigParserInterface
     */
    private $editorConfigParser;
    /**
     * @var FileFormatterInterface[]
     */
    private $fileFormatters = [];
    /**
     * @var ParameterProvider
     */
    private $parameterProvider;
    /**
     * @param FileFormatterInterface[] $fileFormatters
     */
    public function __construct(\Rector\FileFormatter\Contract\EditorConfig\EditorConfigParserInterface $editorConfigParser, \RectorPrefix20210508\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider, array $fileFormatters = [])
    {
        $this->editorConfigParser = $editorConfigParser;
        $this->fileFormatters = $fileFormatters;
        $this->parameterProvider = $parameterProvider;
    }
    /**
     * @param File[] $files
     */
    public function format(array $files) : void
    {
        foreach ($files as $file) {
            if (!$file->hasChanged()) {
                continue;
            }
            foreach ($this->fileFormatters as $fileFormatter) {
                if (!$fileFormatter->supports($file)) {
                    continue;
                }
                $editorConfigConfigurationBuilder = $fileFormatter->createDefaultEditorConfigConfigurationBuilder();
                $this->sniffOriginalFileContent($file, $editorConfigConfigurationBuilder);
                $editorConfiguration = $this->createEditorConfiguration($file, $editorConfigConfigurationBuilder);
                $fileFormatter->format($file, $editorConfiguration);
            }
        }
    }
    private function sniffOriginalFileContent(\Rector\Core\ValueObject\Application\File $file, \Rector\FileFormatter\ValueObjectFactory\EditorConfigConfigurationBuilder $editorConfigConfigurationBuilder) : void
    {
        // Try to sniff into the original content to get the indentation and new line
        try {
            $indent = \Rector\FileFormatter\ValueObject\Indent::fromContent($file->getOriginalFileContent());
            $editorConfigConfigurationBuilder->withIndent($indent);
        } catch (\Rector\FileFormatter\Exception\ParseIndentException $parseIndentException) {
        }
        try {
            $newLine = \Rector\FileFormatter\ValueObject\NewLine::fromContent($file->getOriginalFileContent());
            $editorConfigConfigurationBuilder->withNewLine($newLine);
        } catch (\Rector\FileFormatter\Exception\InvalidNewLineStringException $invalidNewLineStringException) {
        }
    }
    private function createEditorConfiguration(\Rector\Core\ValueObject\Application\File $file, \Rector\FileFormatter\ValueObjectFactory\EditorConfigConfigurationBuilder $editorConfigConfigurationBuilder) : \Rector\FileFormatter\ValueObject\EditorConfigConfiguration
    {
        if (!$this->parameterProvider->provideBoolParameter(\Rector\Core\Configuration\Option::ENABLE_EDITORCONFIG)) {
            return $editorConfigConfigurationBuilder->build();
        }
        return $this->editorConfigParser->extractConfigurationForFile($file, $editorConfigConfigurationBuilder);
    }
}
