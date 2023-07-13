<?php

namespace App\ConsoleCommands;

use App\Product\ProductRepository;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PrintProducts extends Command
{
    private ProductRepository $productRepository;

    protected function configure()
    {
        $this->productRepository = new ProductRepository();

        $this->setName('print')
            ->setDescription('Runs sentiment description analyzer.')
            ->setHelp('Allows you to find and analyze sentiment product data.')
            ->addOption(
                'all',
                'a',
                InputOption::VALUE_OPTIONAL,
                'Print product data with sentiment evaluation of both internal and external services'
            )
            ->addOption(
                'external',
                'e',
                InputOption::VALUE_OPTIONAL,
                'Print product data with sentiment evaluation of external services'
            )
            ->addOption(
                'internal',
                'i',
                InputOption::VALUE_OPTIONAL,
                'Print product data with sentiment evaluation of internal services'
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws GuzzleException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $table = new Table($output);
        $output->writeln('Product data and sentiment is about to cleared...');

        if ($input->getOption('internal')) {
            $output->writeln('List of all products and description scores calculated by internal service:');
            $result = $this->productRepository->evaluateAllByInternal();
            $this->buildTable($table, $result);

        } else if ($input->getOption('external')) {
            $output->writeln('List of all products and description scores calculated by external service:');
            $output->writeln('It might take some time...');
            $result = $this->productRepository->evaluateAllByExternal();
            $this->buildTable($table, $result);

        } else {
            $output->writeln('List of all products and description arithmetic mean scores calculated by external and internal service:');
            $output->writeln('It might take some time...');
            $result = $this->productRepository->evaluateAllByMixed();
            $this->buildTable($table, $result);
        }

        $output->writeln('Last two rows are the MAX and MIN values.');
        $output->writeln('Complete.');
        return Command::SUCCESS;
    }

    protected function buildTable(Table $table, array $data)
    {
        usort($data, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        $tableData = [];
        $lastArrNumb = count($data) - 1;
        $maxScore = $data[0]['score'];
        $minScore = $data[$lastArrNumb]['score'];

        foreach ($data as $row) {
            $name = strlen($row['name']) > 45 ? substr($row['name'], 0, 42) . '...' : $row['name'];
            $description = strlen($row['description']) > 100 ? substr($row['description'], 0, 97) . '...' : $row['description'];
            $score = round(floatval($row['score']), 5);
            $formattedScore = $score;

            if ($score === $maxScore) {
                $formattedScore = '<fg=green>' . $score . '</>';
            } elseif ($score === $minScore) {
                $formattedScore = '<fg=red>' . $score . '</>';
            }

            $tableData[] = [
                'name' => $name,
                'score' => $formattedScore,
                'description' => $description,
            ];
        }

        $table
            ->setHeaders(['Name', 'Score', 'Description'])
            ->setRows($tableData);

        $table->addRows([
            new TableSeparator(),
            ['<fg=green>' . $tableData[0]['name'], $tableData[0]['score'], $tableData[0]['description'] . '</>'],
            ['<fg=red>' . $tableData[$lastArrNumb]['name'], $tableData[$lastArrNumb]['score'], $tableData[$lastArrNumb]['description'] . '</>'],
        ]);

        $table->render();
    }
}