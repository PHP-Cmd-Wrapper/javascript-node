<?php

namespace CmdWrapper\Wrapper\Javascript;

use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\Result\CommandResult;
use CmdWrapper\Wrapper\Attributes\EqualsCommand;
use CmdWrapper\Wrapper\Core\BinWrapper;

class Npm extends BinWrapper
{
    protected static string $defaultBinary = 'npm';

    public function runScript(string $scriptName): CommandResult
    {
        return $this
            ->newCommand()
            ->addArgument('run-script')
            ->addArgument($scriptName)
            ->executeOrFail($this->getCommandExecutor());
    }

    #[EqualsCommand('npm install')]
    public function install(): CommandResult
    {
        return $this
            ->newCommand()
            ->addArgument('install')
            ->executeOrFail($this->getCommandExecutor());
    }

    #[EqualsCommand('npm list')]
    #[EqualsCommand('npm list -g')]
    public function list(bool $global = false): array
    {
        return $this
            ->newCommand()
            ->addArgument('list')
            ->when($global, fn (ShellCommandInterface $cmd) => $cmd->addCutOption('g'))
            ->executeOrFail($this->getCommandExecutor())
            ->getResult()
            ->lines()
            ->toArray();
    }
}
