<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class Run extends Command
{
    protected function configure()
    {
        $this->setName('run')
            ->setDescription('Runs sentiment description analyzer!');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
//        $output->writeln('Hello World!');
        return Command::SUCCESS;
    }
}