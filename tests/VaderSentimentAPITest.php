<?php

use App\InternalAPIs\VaderSentimentAPI;
use App\Product\Product;
use PHPUnit\Framework\TestCase;
use Sentiment\Analyzer;

class VaderSentimentAPITest extends TestCase
{
    private VaderSentimentAPI $api;
    private Analyzer $analyzer;

    protected function setUp(): void
    {
        $this->api = new VaderSentimentAPI();
        $this->analyzer = new Analyzer();
    }

    public function testGetSentiment()
    {
        $product = new Product('Caffeine 90 tbl - GymBeam', 'Caffeine is made by caffeine tablets with up to 200 mg of caffeine, the most popular stimulant in the world. It is used by bodybuilders, athletes, but also by other athletes who need to increase attention and alertness before training.');

        $expectedSentiment = [
            'pos' => 0.119,
            'neg' => 0.0,
            'neu' => 0.881,
            'compound' => 0.61
        ];

        $result = $this->api->getSentiment($product);

        $this->assertEquals($expectedSentiment, $result);
    }

    public function testGetAllSentiments()
    {
        $products = [
            new Product('Caffeine 90 tbl - GymBeam', 'Caffeine is made by caffeine tablets with up to 200 mg of caffeine, the most popular stimulant in the world. It is used by bodybuilders, athletes, but also by other athletes who need to increase attention and alertness before training.'),
            new Product('Micellar Casein Protein 1000 g - GymBeam', 'Micellar Casein is a protein food supplement having up to 75% portion of protein, and its main advantage is slow (up to 7 hours), gradual and even absorption of amino acids in the body. Therefore is used as a night protein before bedtime and releases troughout the night. It provides better recovery, prevents catabolism and ensures even better protein utilization.'),
            new Product('Synephrine 90 tablets - GymBeam', 'Synephrine is one of the most popular fat burners that can support thermogenesis. It contributes to activation of β-3 adrenoreceptors that increase thermogenesis and also support fat breakdown. It is affordably priced and is a natural compound.'),
        ];

        $results = $this->api->getAllSentiments($products);
        $scoresToCompare = [];
        foreach ($results as $data) {
            $scoresToCompare[] = $data['score'];
        }

        $expectedSentiments = [0.61, 0.7964, 0.9055];
        $this->assertEquals($expectedSentiments, $scoresToCompare);
    }

    public function testAddNewWords()
    {
        $newWords = [
            'rubbish' => '-1.5',
            'mediocre' => '-1.0',
            'aggressive' => '-0.5'
        ];

        $this->analyzer->updateLexicon($newWords);

        $this->assertEquals('0.545', $this->analyzer->getSentiment('Weather today is rubbish')['neu']);
        $this->assertEquals('0.6', $this->analyzer->getSentiment('His skills are mediocre')['neu']);
        $this->assertEquals('0.662', $this->analyzer->getSentiment('She is seemingly very aggressive')['neu']);
    }
}
