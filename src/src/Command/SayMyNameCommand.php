<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:say-my-name',
    description: 'A command that knows who it is... but not much more.',
)]
class SayMyNameCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('to-upper', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $name = $input->getArgument('name') ?: 'Heisenberg'; // Default to Heisenberg
        $shouldYell = $input->getOption('to-upper');

        $message = sprintf('My name is %s.', $name);
        if ($shouldYell) {
            $message = strtoupper($message); // Convert to uppercase if --yell is provided
        }

        $io->success($message);
        return Command::SUCCESS;
    }
}
