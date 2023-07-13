<?php

use App\Product;
use App\TwinwordSentimentAPI;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class TwinwordSentimentAPITest extends TestCase
{
    private $api;
    private $mockClient;

    protected function setUp(): void
    {
        $this->mockClient = $this->createMock(Client::class);
        $this->api = new TwinwordSentimentAPI($this->mockClient);
    }

    /**
     * @return void
     * @throws GuzzleException
     */
    public function testGetSentiment()
    {
        $product = new Product('Caffeine 90 tbl - GymBeam', 'Caffeine is made by caffeine tablets with up to 200 mg of caffeine, the most popular stimulant in the world. It is used by bodybuilders, athletes, but also by other athletes who need to increase attention and alertness before training.');

        $expectedResponse = (object)[
            'type' => 'positive',
            'score' => '0.15728847107142857'
        ];

        $resultFull = $this->api->getSentiment($product);
        $result = (object)[
            'type' => $resultFull->type,
            'score' => $resultFull->score
        ];

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetAllSentiments()
    {
        $products = [
            new Product('Caffeine 90 tbl - GymBeam', 'Caffeine is made by caffeine tablets with up to 200 mg of caffeine, the most popular stimulant in the world. It is used by bodybuilders, athletes, but also by other athletes who need to increase attention and alertness before training.'),
            new Product('Micellar Casein Protein 1000 g - GymBeam', 'Micellar Casein is a protein food supplement having up to 75% portion of protein, and its main advantage is slow (up to 7 hours), gradual and even absorption of amino acids in the body. Therefore is used as a night protein before bedtime and releases troughout the night. It provides better recovery, prevents catabolism and ensures even better protein utilization.'),
            new Product('Synephrine 90 tablets - GymBeam', 'Synephrine is one of the most popular fat burners that can support thermogenesis. It contributes to activation of β-3 adrenoreceptors that increase thermogenesis and also support fat breakdown. It is affordably priced and is a natural compound.'),
        ];

        $result = $this->api->getAllSentiments($products);

        $this->assertCount(3, $result);
        $this->assertEquals('0.15728847107142857', $result[0]['score']);
        $this->assertEquals('0.13777719254924242', $result[1]['score']);
        $this->assertEquals('0.19453355700000005', $result[2]['score']);
    }
}
