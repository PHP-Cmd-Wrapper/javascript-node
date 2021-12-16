<?php

namespace CmdWrapper\Wrapper;

use ArtARTs36\ShellCommand\Executors\ProcOpenExecutor;
use ArtARTs36\ShellCommand\Interfaces\CommandBuilder;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandExecutor;
use ArtARTs36\ShellCommand\ShellCommander;
use CmdWrapper\Contracts\ComputedVersion;
use CmdWrapper\Contracts\Version;
use CmdWrapper\Contracts\Wrapper;

class Example implements Wrapper
{
    public function __construct(
        protected CommandBuilder $commandBuilder,
        protected ShellCommandExecutor $commandExecutor,
    ) {
        //
    }

    public static function local(): self
    {
        return new self(new ShellCommander(), new ProcOpenExecutor());
    }

    public function version(): Version
    {
        return new ComputedVersion(...$this
            ->commandBuilder
            ->make('git')
            ->addOption('version')
            ->executeOrFail($this->commandExecutor)
            ->getResult()
            ->delete(['git version '])
            ->trim()
            ->explode('.')
            ->toIntegers());
    }
}
