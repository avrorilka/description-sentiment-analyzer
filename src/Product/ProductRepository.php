<?php

namespace App\Product;

use App\ExternalAPIs\TwinwordSentimentAPI;
use App\InternalAPIs\VaderSentimentAPI;
use GuzzleHttp\Exception\GuzzleException;

class ProductRepository
{
    private array $formattedProducts;
    private TwinwordSentimentAPI $twinword;
    private VaderSentimentAPI $vader;

    public function __construct()
    {
        $this->vader = new VaderSentimentAPI();
        $this->twinword = new TwinwordSentimentAPI();

        $descriptionProvider = new ProductCSVReader();
        $this->formattedProducts = $descriptionProvider->readProducts();
    }

    /**
     * @return array
     */
    public function evaluateAllByInternal(): array
    {
        return $this->vader->getAllSentiments($this->formattedProducts);
    }

    /**
     * @return array
     * @throws GuzzleException
     */
    public function evaluateAllByExternal(): array
    {
        return $this->twinword->getAllSentiments($this->formattedProducts);
    }

    /**
     * @return array
     * @throws GuzzleException
     */
    public function evaluateAllByMixed(): array
    {
        $externalData = $this->evaluateAllByExternal();
        $internalData = $this->evaluateAllByInternal();

        $mixedData = [];

        foreach ($externalData as $key => $value) {
            $mixedData[$key]['name'] = $value['name'];
            $mixedData[$key]['description'] = $value['description'];
            $mixedData[$key]['score'] = (string)((floatval($value['score']) + floatval($internalData[$key]['score'])) / 2);
            $mixedData[$key]['type'] = $value['type'];
        }

        return $mixedData;
    }
}