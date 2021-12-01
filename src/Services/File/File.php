<?php

namespace App\Services\File;

abstract class File
{
    protected string $name;

    public function __construct(string $name) {
        $this->name = $name;
    }

    public function load() {}

    public function write() {}

    public function checkExistence(): bool {
        return file_exists($this->name);
    }
}