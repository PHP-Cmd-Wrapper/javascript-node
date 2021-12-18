<?php

namespace CmdWrapper\Wrapper\Javascript\Node;

use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\Result\CommandResult;
use CmdWrapper\Wrapper\Attributes\EqualsCommand;
use CmdWrapper\Wrapper\Core\BinWrapper;

class Npm extends BinWrapper
{
    protected static string $defaultBinary = 'npm';

    #[EqualsCommand('npm run-script $scriptName')]
    public function runScript(string $scriptName, bool $noOutput = true): CommandResult
    {
        return $this
            ->newCommand()
            ->addArgument('run-script')
            ->addArgument($scriptName)
            ->when($noOutput, function (ShellCommandInterface $command) {
                $command->setErrorFlow('/dev/null');
            })
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
