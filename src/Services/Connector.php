<?php

namespace Qortex\Webtronics\Services;

use GuzzleHttp\Client;
use stdClass;

class Connector
{
    private string $apiKey;
    private string $projectId;
    private string $apiUrl;
    private bool $cacheResults;
    private string $cacheDirectory;

    public function __construct($apiKey, $projectId, $apiUrl = null, $cacheResults = true, $cacheDirectory = '/tmp/')
    {
        $this->apiKey = $apiKey;
        $this->projectId = $projectId;
        $this->apiUrl = $apiUrl ?? 'https://backend.webtronica.ru/';
        $this->cacheResults = $cacheResults;
        $this->cacheDirectory = $cacheDirectory;
    }

    private function prepareRequest($endpoint)
    {
        $client = new Client([
            'base_uri' => $this->apiUrl,
            'http_errors' => false
        ]);
        return $client;
    }

    private function sendGetRequest($endpoint, $query = [])
    {
        $client = $this->prepareRequest($endpoint);
        $response = $client->request('GET', $endpoint, ['query' => $query]);
        return json_decode($response->getBody()->getContents());
    }

    private function getUrlFileName(string $url, string $prefix = '')
    {
        return ($prefix !== ''  ?? $prefix . '_') . md5($url);
    }

    private function saveResultsToCache(string $url, $dataType, $data)
    {
        if (!$this->cacheResults) {
            return;
        }
        $cacheFileName = $this->cacheDirectory . $this->getUrlFileName($url, $dataType);
        file_put_contents($cacheFileName, $data);
    }

    private function loadResultsFromCache(string $url, $dataType)
    {
        if (!$this->cacheResults) {
            return new stdClass;
        }
        $cacheFileName = $this->cacheDirectory . $this->getUrlFileName($url, $dataType);
        if (file_exists($cacheFileName)) {
            return json_decode(file_get_contents($cacheFileName));
        }
        return new stdClass;
    }

    private  function parseResults($data)
    {
        return json_decode($data, true);
    }

    public function queryUrlTags(string $url)
    {
        $tagsLoadedFromService = false;
        try {
            $tags = $this->sendGetRequest('tags/' . $this->apiKey . '/' . $this->projectId, ['url' => $url]);
            if ($tags) {
                $tagsLoadedFromService = true;
            }
        } catch (\Exception $e) {
        }
        if (!$tagsLoadedFromService) {
            $tags = $this->loadResultsFromCache($url, 'tags');
        }
        return $tags;
    }
}
