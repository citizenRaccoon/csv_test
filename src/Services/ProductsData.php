<?php

namespace App\Services;

use App\Entity\TblProductData;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ProductsData
{

    private array $data;

    private array $errors;

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function __construct(array $data, string $source = 'csv')
    {
        $this->data = $data;

        if($source == 'csv') {
            $this->transformCSVDataToAssocArray();
        }
    }

    private function filterDataByTheRules()
    {
        //TODO: Need to connect with bank API to know exact rate
        $UsdToGbpRate = 1.34;
        foreach ($this->data as $productKey => $product) {
            if(substr($product['floatPrice'], 0, 1) != '$')
                $product['floatPrice'] = $product['floatPrice'] * $UsdToGbpRate;
            else {
                $product['floatPrice'] = substr($product['floatPrice'], 1);
            }

            $productName = $product['strProductName'];

            $statement = $product['floatPrice'] < 5 && $product['intStock'] < 10;
            $errorMessage = "The price can't be less than \$5 with stock less than 10. ";
            $errorMessage .="Product $productName will not be imported.";
            if($this->validate($statement, $errorMessage)) {
                unset($this->data[$productKey]);
            }
            $statement = $product['floatPrice'] > 1000;
            $errorMessage = 'The price can\'t be more than $1000. ';
            $errorMessage .="Product $productName will not be imported.";
            if($this->validate($statement, $errorMessage)) {
                unset($this->data[$productKey]);
            }
        }
    }

    private function validate($statement, $errorText): bool
    {
        if($statement) {
            return true;
        } else {
            $this->errors[] = $errorText;
            return false;
        }
    }

    private function transformCSVDataToAssocArray()
    {
        $assocArray = [];

        foreach ($this->data as $row) {
            //Check if it's header
            if(!is_numeric($row[3])) {
                continue;
            }
            $product = [
                'strProductName' => $this->changeEncodingToUTF8($row[1]),
                'strProductDesc' => $this->changeEncodingToUTF8($row[2]),
                'strProductCode' => $this->changeEncodingToUTF8($row[0]),
                'intStock' => $row[3],
                'floatPrice' => $row[4],
                'discontinued' => $row[5]
            ];
            $assocArray[] = $product;
        }
        $this->data = $assocArray;
    }

    private function changeEncodingToUTF8(string $text): string
    {
        return iconv(mb_detect_encoding($text, mb_detect_order(), true), "UTF-8", $text);
    }

    public function writeIntoTheTable(ContainerInterface $container)
    {
        $this->filterDataByTheRules();
        foreach ($this->data as $product) {
            $discontinuedTime = !empty($product['discontinued']) ? date('%Y-%m-%d', time()) : "";
            $productDataTable = new TblProductData();
            $productDataTable->setStrProductName($product['strProductName']);
            $productDataTable->setStrProductDesc($product['strProductDesc']);
            $productDataTable->setStrProductCode($product['strProductCode']);
            $productDataTable->setDtmAdded(date('%Y-%m-%d', time()));
            $productDataTable->setDtmDiscontinued($discontinuedTime);
            $productDataTable->setIntStock($product['intStock']);
            $productDataTable->setFloatPrice($product['floatPrice']);
            $productDataTable->setStmTimestamp(time());

            $entityManager = $container->get('doctrine')->getManager();

            $entityManager->persist($product);

            $entityManager->flush();
        }
    }
}