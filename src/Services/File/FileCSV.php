<?php

namespace App\Common\File;

class FileCSV extends File
{

    private string $error = "";

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @return array|false
     *
     * Method returns array and false in case of any errors. Errors text store in $error property.
     */
    public function load()
    {
        $csvArray = array();
        if(!$this->checkExistence()) {
            $this->error = "This file is not exists.";
            return false;
        }
        $handle = fopen($this->name, "r");
        if($handle === FALSE) {
            $this->error = "Can't open file.";
            return false;
        }
        while($csvData = fgetcsv($handle) !== FALSE) {
            $csvArray[] = $csvData;
        }
        return $csvArray;
    }
}