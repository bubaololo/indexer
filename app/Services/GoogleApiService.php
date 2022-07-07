<?php

namespace App\Services;

use Google_Client;
use Illuminate\Support\Facades\Storage;
use App\Events\UrlProcessed;
use App\Services\ApiKeysService;

class GoogleApiService
{
    /**
    * This class provides acces to Google API's, using "google/apiclient" package
    * @return string
    */


    private $client;

    public function __construct(Google_Client $client)
    {
        $this->client = $client;
    }


    /**
        * Main method for sending requests to API
        * @param string $apiKey # of API key, substituted in name of file
        * @param string $textareaData string with urls
        * @param $actionType type of request to
        * @return string
        */


    public function sendRequest($apiKey, $url, $actionType, $userId)
    {
        $this->client->setAuthConfig(Storage::path('keys/'.$apiKey.'.json'));
        $this->client->addScope('https://www.googleapis.com/auth/indexing');
        $httpClient = $this->client->authorize();
        $endpoint = 'https://indexing.googleapis.com/v3/urlNotifications:publish';
        
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                // return $result[] =  $url.'URL не является корректным.';
                
                exit(UrlProcessed::dispatch($url.'URL не является корректным.',$userId));
            } elseif ($actionType == 'get') {
                $response = $httpClient->get('https://indexing.googleapis.com/v3/urlNotifications/metadata?url=' . urlencode($url));
            } else {
                $content = json_encode([
        'url' => $url,
        'type' => $actionType
      ]);
                $response = $httpClient->post($endpoint, ['body' => $content]);
                ApiKeysService::decrementKey($apiKey);
            }

            $result = json_decode($response->getBody(), true);

            UrlProcessed::dispatch($result,$userId);

    }
}
