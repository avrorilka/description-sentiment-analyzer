<?php

namespace App;

class CSVFileDescriptionProvider implements DescriptionProviderInterface
{
    private $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function readProducts(): array
    {
        $rows = file($this->file, FILE_IGNORE_NEW_LINES);

        $descriptions = [];
        foreach ($rows as $index => $row) {
            if ($index === 0) {
                continue;
            }

            $data = str_getcsv($row);
            $name = trim($data[0], '"');

            $description = trim($data[1], '"');
            $description = strip_tags($description);

            $descriptions[] = new Product($name, $description);
        }

        return $descriptions;
    }
}
