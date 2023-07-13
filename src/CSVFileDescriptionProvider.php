<?php

namespace App;

class CSVFileDescriptionProvider implements DescriptionProviderInterface
{
    private string $filePath;

    /**
     * @param $filePath
     */
    public function __construct($filePath = null)
    {
        empty($filePath) ?: $this->filePath = $filePath;

        if (is_null($filePath)) {
            $this->filePath = './products.csv';
        }
    }

    public function readProducts(): array
    {
        $products = [];

        $handle = fopen($this->filePath, "r");
        while (($row = fgetcsv($handle)) !== false) {
            if ($row[0] == 'name' && $row[1] == 'description') {
                continue;
            }
            $name = $row[0] ?? '';
            $description = trim(strip_tags($row[1])) ?? '';

            $products[] = empty($name) ?: new Product($name, $description);
        }
        fclose($handle);

        return $products;
    }
}
