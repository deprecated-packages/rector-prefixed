<?php

declare (strict_types=1);
namespace RectorPrefix20210504\App\BotCommentParser;

use RectorPrefix20210504\League\CommonMark\Block\Element\FencedCode;
use RectorPrefix20210504\League\CommonMark\DocParser;
use RectorPrefix20210504\League\CommonMark\Inline\Element\Link;
class BotCommentParser
{
    private \RectorPrefix20210504\League\CommonMark\DocParser $docParser;
    public function __construct(\RectorPrefix20210504\League\CommonMark\DocParser $docParser)
    {
        $this->docParser = $docParser;
    }
    public function parse(string $text) : \RectorPrefix20210504\App\BotCommentParser\BotCommentParserResult
    {
        $document = $this->docParser->parse($text);
        $walker = $document->walker();
        $hashes = [];
        $diffs = [];
        while ($event = $walker->next()) {
            if (!$event->isEntering()) {
                continue;
            }
            $node = $event->getNode();
            if ($node instanceof \RectorPrefix20210504\League\CommonMark\Inline\Element\Link) {
                $url = $node->getUrl();
                $match = \RectorPrefix20210504\Nette\Utils\Strings::match($url, '/^https:\\/\\/phpstan\\.org\\/r\\/([0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12})$/i');
                if ($match === null) {
                    continue;
                }
                $hashes[] = $match[1];
                continue;
            }
            if (!$node instanceof \RectorPrefix20210504\League\CommonMark\Block\Element\FencedCode) {
                continue;
            }
            if ($node->getInfo() !== 'diff') {
                continue;
            }
            $diffs[] = $node->getStringContent();
        }
        if (\count($hashes) !== 1) {
            throw new \RectorPrefix20210504\App\BotCommentParser\BotCommentParserException();
        }
        if (\count($diffs) !== 1) {
            throw new \RectorPrefix20210504\App\BotCommentParser\BotCommentParserException();
        }
        return new \RectorPrefix20210504\App\BotCommentParser\BotCommentParserResult($hashes[0], $diffs[0]);
    }
}
