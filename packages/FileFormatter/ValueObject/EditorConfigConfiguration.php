<?php

declare (strict_types=1);
namespace Rector\FileFormatter\ValueObject;

/**
 * @see \Rector\Tests\FileFormatter\ValueObject\EditorConfigConfigurationTest
 */
final class EditorConfigConfiguration
{
    /**
     * @var NewLine
     */
    private $newLine;
    /**
     * @var bool
     */
    private $insertFinalNewline = \false;
    /**
     * @var Indent
     */
    private $indent;
    public function __construct(\Rector\FileFormatter\ValueObject\Indent $indent, \Rector\FileFormatter\ValueObject\NewLine $newLine, bool $insertFinalNewline)
    {
        $this->indent = $indent;
        $this->newLine = $newLine;
        $this->insertFinalNewline = $insertFinalNewline;
    }
    public function getNewLine() : string
    {
        return $this->newLine->__toString();
    }
    public function getFinalNewline() : string
    {
        return $this->insertFinalNewline ? $this->getNewLine() : '';
    }
    public function getIndent() : string
    {
        return $this->indent->__toString();
    }
    public function getIndentStyleCharacter() : string
    {
        return $this->indent->getIndentStyleCharacter();
    }
    public function getIndentStyle() : string
    {
        return $this->indent->getIndentStyle();
    }
    public function getIndentSize() : int
    {
        return $this->indent->getIndentSize();
    }
}
