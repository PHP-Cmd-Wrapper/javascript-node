<?php

namespace CmdWrapper\Wrapper\Javascript\Node\Tests;

use ArtARTs36\ShellCommand\Executors\TestExecutor;
use ArtARTs36\ShellCommand\ShellCommander;
use CmdWrapper\Wrapper\Core\RunContext;
use CmdWrapper\Wrapper\Javascript\Node\Node;
use PHPUnit\Framework\TestCase;

class NodeTest extends TestCase
{
    /**
     * @covers \CmdWrapper\Wrapper\Javascript\Node\Node::version
     */
    public function testVersion(): void
    {
        $wrapper = new Node(
            new ShellCommander(),
            TestExecutor::fromSuccess('v14.18.1'),
            new RunContext('', ''),
        );

        $resultVersion = $wrapper->version();

        self::assertEquals([14, 18, 1], [$resultVersion->major(), $resultVersion->minor(), $resultVersion->patch()]);
    }
}
