<?php

namespace CmdWrapper\Wrapper\Tests;

use ArtARTs36\ShellCommand\Executors\TestExecutor;
use ArtARTs36\ShellCommand\ShellCommander;
use CmdWrapper\Wrapper\Example;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * @covers \CmdWrapper\Wrapper\Example::version
     */
    public function testVersion(): void
    {
        $wrapper = new Example(
            new ShellCommander(),
            TestExecutor::fromSuccess('git version 1.2.3'),
        );

        $resultVersion = $wrapper->version();

        self::assertEquals([1, 2, 3], [$resultVersion->major(), $resultVersion->minor(), $resultVersion->patch()]);
    }
}
