<?php

namespace App\InternalAPIs;

use App\Product\Product;
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
        $productsSentiment = [];

        foreach ($arrayOfProducts as $product) {
            $sentiment = $this->getSentiment($product);
            $score = $sentiment['compound'];
            $type = match (true) {
                $score >= 0 => 'positive',
                $score <= 0 => 'negative',
                $score === 0 => 'neutral',
            };

            $productsSentiment[] = [
                'name' => $product->name,
                'description' => $product->description,
                'score' => $score,
                'type' => $type
            ];
        }

        return $productsSentiment;
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