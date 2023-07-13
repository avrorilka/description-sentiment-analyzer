<?php

namespace App\ExternalAPIs;

use App\Product\Product;

interface ExternalSentimentApiInterface
{
    public function getSentiment(Product $product): object;

    public function getAllSentiments(array $arrayOfProducts): array;
}