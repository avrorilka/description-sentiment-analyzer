<?php

namespace App;

interface InternalSentimentApiInterface
{
    public function getSentiment(Product $product): array;
    public function getAllSentiments(array $arrayOfProducts): array;
    public function addNewWords(array $newWords): void;
}