<?php

namespace Product;

use App\Product\ProductCSVReader;
use PHPUnit\Framework\TestCase;

class ProductCSVReaderTest extends TestCase
{
    private string $file;
    private string $fileEmpty;

    protected function setUp(): void
    {
        $this->file = 'tests/data/sample.csv';
        $this->fileEmpty = 'tests/data/sample-empty.csv';
    }

    public function testGetDescriptions()
    {
        $descriptionProvider = new ProductCSVReader($this->file);
        $descriptions = $descriptionProvider->readProducts();

        // Assertions
        $this->assertIsArray($descriptions);
        $this->assertCount(3, $descriptions);

        $this->assertEquals('Caffeine 90 tbl - GymBeam', $descriptions[0]->name);
        $this->assertEquals('Caffeine is made by caffeine tablets with up to 200 mg of caffeine, the most popular stimulant in the world. It is used by bodybuilders, athletes, but also by other athletes who need to increase attention and alertness before training.', $descriptions[0]->description);

        $this->assertEquals('Micellar Casein Protein 1000 g - GymBeam', $descriptions[1]->name);
        $this->assertEquals('Micellar Casein is a protein food supplement having up to 75% portion of protein, and its main advantage is slow (up to 7 hours), gradual and even absorption of amino acids in the body. Therefore is used as a night protein before bedtime and releases troughout the night. It provides better recovery, prevents catabolism and ensures even better protein utilization.', $descriptions[1]->description);

        $this->assertEquals('Synephrine 90 tablets - GymBeam', $descriptions[2]->name);
        $this->assertEquals('Synephrine is one of the most popular fat burners that can support thermogenesis. It contributes to activation of β-3 adrenoreceptors that increase thermogenesis and also support fat breakdown. It is affordably priced and is a natural compound.', $descriptions[2]->description);
    }

    public function testEmptyFile()
    {
        $descriptionProvider = new ProductCSVReader($this->fileEmpty);
        $descriptions = $descriptionProvider->readProducts();

        // Assertions
        $this->assertIsArray($descriptions);
        $this->assertEmpty($descriptions);
    }
}
