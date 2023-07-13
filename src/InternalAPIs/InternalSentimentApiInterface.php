<?php

namespace App\InternalAPIs;

use App\Product\Product;

interface InternalSentimentApiInterface
{
    public function getSentiment(Product $product): array;

    public function getAllSentiments(array $arrayOfProducts): array;

    public function addNewWords(array $newWords): void;
}