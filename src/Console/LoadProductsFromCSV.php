<?php

namespace App\Console;

use App\Services\File\FileCSV;
use App\Services\ProductsData;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadProductsFromCSV extends Command
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    protected static $defaultName = 'app:load-products-csv';

    protected function configure(): void
    {
        $this->setDescription("Adds products that was loaded from CSV file");
        $this->setHelp("");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getFirstArgument();
        $csv = new FileCSV($name);
        $csvArray = $csv->load();

        $productsData = new ProductsData($csvArray);
        $productsData->writeIntoTheTable($this->container);

        foreach($productsData->getErrors() as $error)
            echo $error . "\n";

        return Command::SUCCESS;
    }
}