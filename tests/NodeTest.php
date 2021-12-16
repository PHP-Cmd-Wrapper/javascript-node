<?php

namespace CmdWrapper\Wrapper\Javascript\Tests;

use ArtARTs36\ShellCommand\Executors\TestExecutor;
use ArtARTs36\ShellCommand\ShellCommander;
use CmdWrapper\Wrapper\Javascript\Node;
use PHPUnit\Framework\TestCase;

class NodeTest extends TestCase
{
    /**
     * @covers \CmdWrapper\Wrapper\Javascript\Node::version
     */
    public function testVersion(): void
    {
        $wrapper = new Node(
            new ShellCommander(),
            TestExecutor::fromSuccess('git version 1.2.3'),
        );

        $resultVersion = $wrapper->version();

        self::assertEquals([1, 2, 3], [$resultVersion->major(), $resultVersion->minor(), $resultVersion->patch()]);
    }
}
