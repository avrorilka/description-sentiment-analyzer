<?php

namespace App;

interface ExternalSentimentApiInterface
{
    public function getSentiment(Product $product): object;
    public function getAllSentiments(array $arrayOfProducts): array;
}