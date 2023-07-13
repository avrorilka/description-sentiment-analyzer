<?php

namespace App\Commands;

use App\ProductRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

class Run extends Command
{
    private ProductRepository $productRepository;

    public function __construct($name)
    {
        parent::__construct($name);
        $this->productRepository = new ProductRepository();
    }

    protected function configure()
    {
        $this->setName('run')
            ->setDescription('Runs sentiment description analyzer.')
            ->setHelp('Allows you to find and analyze sentiment product data.')
            ->addOption(
                'all',
                'a',
                InputOption::VALUE_OPTIONAL,
                'Print product data with sentiment evaluation of both internal and external services'
            )
            ->addOption(
                'external only',
                'e',
                InputOption::VALUE_OPTIONAL,
                'Print product data with sentiment evaluation of external services'
            )
            ->addOption(
                'internal only',
                'i',
                InputOption::VALUE_OPTIONAL,
                'Print product data with sentiment evaluation of internal services'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Product data and sentiment is about to cleared...');

        if ($input->getOption('internal')) {
            $this->productRepository->internal();
            $output->writeln('All internal  are cleared.');

        } else if ($input->getOption('external')) {
            $this->productRepository->external();
            $output->writeln('All external are cleared.');

        } else {
            $this->productRepository->mixed();
            $output->writeln('All caches are cleared.');
        }

        $output->writeln('Complete.');
        return Command::SUCCESS;
    }
}