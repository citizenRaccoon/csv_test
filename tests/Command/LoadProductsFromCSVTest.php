<?php

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class LoadProductsFromCSVTest extends KernelTestCase
{
    public function testExecute()
    {
        //TODO: In progress. Now it's just placeholder
        $kernel = self::bootKernel();
        $app = new Application($kernel);

        $cmd = $app->find('app:load-products-csv');
        $cmdTester = new CommandTester($cmd);
        $cmdTester->execute(['resources/test.csv']);
    }
}