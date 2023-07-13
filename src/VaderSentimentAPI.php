<?php

namespace App;

use Sentiment\Analyzer;

class VaderSentimentAPI implements InternalSentimentApiInterface
{
    private Analyzer $analyzer;

    public function __construct()
    {
        $this->analyzer = new Analyzer();
    }

    /**
     * @param Product $product
     * @return array
     */
    public function getSentiment(Product $product): array
    {
        return $this->analyzer->getSentiment($product->description);
    }

    /**
     * @param array $arrayOfProducts
     * @return array
     */
    public function getAllSentiments(array $arrayOfProducts): array
    {
        $sentiments = [];

        foreach ($arrayOfProducts as $product) {
            $sentiment = $this->getSentiment($product);
            $sentiments[] = $sentiment;
        }

        return $sentiments;
    }

    /**
     * @param array $newWords
     * @return void
     */
    public function addNewWords(array $newWords): void
    {
        $this->analyzer->updateLexicon($newWords);
    }
}