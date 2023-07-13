<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use stdClass;

class TwinwordSentimentAPI implements ExternalSentimentApiInterface
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param Product $product
     * @return object
     * @throws GuzzleException
     */
    public function getSentiment(Product $product): object
    {
        return $this->makeSentimentRequest($product->description);
    }

    /**
     * @param array $arrayOfProducts
     * @return array
     * @throws GuzzleException
     */
    public function getAllSentiments(array $arrayOfProducts): array
    {
        $productsSentiment = [];

        foreach ($arrayOfProducts as $product) {
            $sentiment = $this->getSentiment($product);
            $productsSentiment[] = [
                'name' => $product->name,
                'description' => $product->description,
                'score' => $sentiment->score,
                'type' => $sentiment->type
            ];
        }

        return $productsSentiment;
    }

    /**
     * @param string $description
     * @return stdClass
     * @throws GuzzleException
     */
    private function makeSentimentRequest(string $description): stdClass
    {
        $url = 'https://twinword-sentiment-analysis.p.rapidapi.com/analyze/?text=' . rawurlencode($description);
        $headers = [
            'X-RapidAPI-Host' => 'twinword-sentiment-analysis.p.rapidapi.com',
            'X-RapidAPI-Key' => 'ab3dbcbe74mshbf9390866b2faa0p1664bfjsn5d8f31686127',
        ];

        $response = $this->client->request('GET', $url, ['headers' => $headers]);
        return json_decode($response->getBody());
    }
}