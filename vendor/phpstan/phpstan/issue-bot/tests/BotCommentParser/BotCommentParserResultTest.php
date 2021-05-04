<?php

declare (strict_types=1);
namespace RectorPrefix20210504\App\BotCommentParser;

use RectorPrefix20210504\League\CommonMark\DocParser;
use RectorPrefix20210504\League\CommonMark\Environment;
use RectorPrefix20210504\League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use RectorPrefix20210504\PHPUnit\Framework\TestCase;
class BotCommentParserResultTest extends \RectorPrefix20210504\PHPUnit\Framework\TestCase
{
    /**
     * @return iterable<array{string, string, string}>
     */
    public function dataParse() : iterable
    {
        (yield ['@foobar After [the latest commit to dev-master](https://github.com/phpstan/phpstan-src/commit/abc123), PHPStan now reports different result with your [code snippet](https://phpstan.org/r/74c3b0af-5a87-47e7-907a-9ea6fbb1c396):

```diff
@@ @@
-1: abc
+1: def
```', '74c3b0af-5a87-47e7-907a-9ea6fbb1c396', '@@ @@
-1: abc
+1: def
']);
    }
    /**
     * @dataProvider dataParse
     */
    public function testParse(string $text, string $expectedHash, string $expectedDiff) : void
    {
        $markdownEnvironment = \RectorPrefix20210504\League\CommonMark\Environment::createCommonMarkEnvironment();
        $markdownEnvironment->addExtension(new \RectorPrefix20210504\League\CommonMark\Extension\GithubFlavoredMarkdownExtension());
        $parser = new \RectorPrefix20210504\App\BotCommentParser\BotCommentParser(new \RectorPrefix20210504\League\CommonMark\DocParser($markdownEnvironment));
        $result = $parser->parse($text);
        $this->assertSame($expectedHash, $result->getHash());
        $this->assertSame($expectedDiff, $result->getDiff());
    }
}
