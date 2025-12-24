<?php

namespace Agencelignani\Pixabaylibrary\Classes;

use Config;
use Exception;

class PixabayService
{
    protected $apiKey;
    protected $endpoint = 'https://pixabay.com/api/';

    public function __construct()
    {
        $this->apiKey = Config::get('agencelignani.pixabaylibrary::api_key');

        if (empty($this->apiKey)) {
            throw new Exception('La clé API Pixabay n’est pas configurée. Ajoutez PIXABAY_API_KEY dans votre fichier .env.');
        }
    }

    public function search(string $query, int $page = 1): array
    {
        $perPage = (int) Config::get('agencelignani.pixabaylibrary::per_page', 24);

        $params = [
            'key'        => $this->apiKey,
            'q'          => $query,
            'image_type' => 'photo',
            'orientation'=> 'horizontal',
            'safesearch' => 'true',
            'per_page'   => $perPage,
            'page'       => $page,
        ];

        $url = $this->endpoint . '?' . http_build_query($params);

        $context = stream_context_create([
            'http' => [
                'timeout' => 8,
            ],
        ]);

        $response = @file_get_contents($url, false, $context);

        if ($response === false) {
            return ['total' => 0, 'hits' => []];
        }

        $data = json_decode($response, true);

        if (!is_array($data) || !isset($data['hits'])) {
            return ['total' => 0, 'hits' => []];
        }

        return $data;
    }
}
