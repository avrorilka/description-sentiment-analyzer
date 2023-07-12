<?php

namespace App;

class Product
{
    public string $name;
    public string $description;

    public function __construct($name, $description)
    {
        $this->name = $name;
        $this->description = $description;
    }
}