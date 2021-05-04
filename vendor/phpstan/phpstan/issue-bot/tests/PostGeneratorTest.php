<?php

declare (strict_types=1);
namespace RectorPrefix20210504\App;

use RectorPrefix20210504\App\Playground\PlaygroundExample;
use RectorPrefix20210504\App\Playground\PlaygroundResult;
use RectorPrefix20210504\App\Playground\PlaygroundResultError;
use RectorPrefix20210504\App\Playground\PlaygroundResultTab;
use RectorPrefix20210504\GuzzleHttp\Promise\FulfilledPromise;
use RectorPrefix20210504\PHPUnit\Framework\TestCase;
use RectorPrefix20210504\SebastianBergmann\Diff\Differ;
use RectorPrefix20210504\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;
class PostGeneratorTest extends \RectorPrefix20210504\PHPUnit\Framework\TestCase
{
    /**
     * @return iterable<array{PlaygroundResult, BotComment[], string|null}>
     */
    public function dataGeneratePosts() : iterable
    {
        $diff = '@@ @@
-1: abc
+1: def
';
        $commentText = "@foobar After [the latest commit in dev-master](https://github.com/phpstan/phpstan-src/commit/abc123), PHPStan now reports different result with your [code snippet](https://phpstan.org/r/abc-def):\n\n```diff\n" . $diff . '```

<details>
 <summary>Full report</summary>

| Line | Error |
|---|---|
| 1 | `def` |

</details>';
        (yield [new \RectorPrefix20210504\App\Playground\PlaygroundResult('abc-def', ['foobar'], [new \RectorPrefix20210504\App\Playground\PlaygroundResultTab('PHP 7.1', [new \RectorPrefix20210504\App\Playground\PlaygroundResultError('abc', 1)])], [new \RectorPrefix20210504\App\Playground\PlaygroundResultTab('PHP 7.1', [new \RectorPrefix20210504\App\Playground\PlaygroundResultError('abc', 1)])]), [], null]);
        (yield [new \RectorPrefix20210504\App\Playground\PlaygroundResult('abc-def', ['foobar'], [new \RectorPrefix20210504\App\Playground\PlaygroundResultTab('PHP 7.1', [new \RectorPrefix20210504\App\Playground\PlaygroundResultError('abc', 1)])], [new \RectorPrefix20210504\App\Playground\PlaygroundResultTab('PHP 7.1', [new \RectorPrefix20210504\App\Playground\PlaygroundResultError('def', 1)])]), [], $commentText]);
        (yield [new \RectorPrefix20210504\App\Playground\PlaygroundResult('abc-def', ['foobar'], [new \RectorPrefix20210504\App\Playground\PlaygroundResultTab('PHP 7.1', [new \RectorPrefix20210504\App\Playground\PlaygroundResultError('abc', 1)])], [new \RectorPrefix20210504\App\Playground\PlaygroundResultTab('PHP 7.1', [new \RectorPrefix20210504\App\Playground\PlaygroundResultError('def', 1)])]), [new \RectorPrefix20210504\App\BotComment('<text>', new \RectorPrefix20210504\App\Playground\PlaygroundExample('', 'abc-def', 'ondrejmirtes', new \RectorPrefix20210504\GuzzleHttp\Promise\FulfilledPromise('foo')), 'some diff')], $commentText]);
        (yield [new \RectorPrefix20210504\App\Playground\PlaygroundResult('abc-def', ['foobar'], [new \RectorPrefix20210504\App\Playground\PlaygroundResultTab('PHP 7.1', [new \RectorPrefix20210504\App\Playground\PlaygroundResultError('abc', 1)])], [new \RectorPrefix20210504\App\Playground\PlaygroundResultTab('PHP 7.1', [new \RectorPrefix20210504\App\Playground\PlaygroundResultError('def', 1)])]), [new \RectorPrefix20210504\App\BotComment('<text>', new \RectorPrefix20210504\App\Playground\PlaygroundExample('', 'abc-def', 'ondrejmirtes', new \RectorPrefix20210504\GuzzleHttp\Promise\FulfilledPromise('foo')), $diff)], null]);
    }
    /**
     * @dataProvider dataGeneratePosts
     * @param BotComment[] $botComments
     */
    public function testGeneratePosts(\RectorPrefix20210504\App\Playground\PlaygroundResult $result, array $botComments, ?string $expectedText) : void
    {
        $generator = new \RectorPrefix20210504\App\PostGenerator(new \RectorPrefix20210504\SebastianBergmann\Diff\Differ(new \RectorPrefix20210504\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder('')), 'abc123');
        $text = $generator->createText($result, $botComments);
        $this->assertSame($expectedText, $text);
    }
}
