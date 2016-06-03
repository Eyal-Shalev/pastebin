<?php


namespace EyalShalev\Pastebin;

use GuzzleHttp\Client as HttpClient;

class Client
{

    const BASE_URL = 'http://pastebin.com';

    protected $httpClient;

    /**
     * @var string
     */
    protected $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->httpClient = new HttpClient($this->getHttpConfiguration());
    }


    public function getPublicRaw($pasteKey) {
        $response = $this->httpClient->post("raw/{$pasteKey}");
        if ($response->getStatusCode() === 200) {
            return $response->getBody()->getContents();
        }
        else {
            $code = $response->getStatusCode();
            $body = $response->getBody()->getContents();
            throw new \HttpResponseException(
`Code: {$code}.
Body: {$body}.`
            );
        }
    }

    protected function getHttpConfiguration() {
        return [
            'base_url' => static::BASE_URL,
            'api_dev_key' => $this->apiKey
        ];
    }
}