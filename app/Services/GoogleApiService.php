<?php

namespace App\Services;

use Google_Client;
use Illuminate\Support\Facades\Storage;

class GoogleApiService
{
    /**
    * This class provides acces to Google API's, using "google/apiclient" package
    * @global Test показываем что мы используем глобальную переменную $a
    * @staticvar string $var Эту переменную мы будем возвращать
    * @param string $param1 Первый параметр функции
    * @param string $param2 Второй параметр
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


    public function indexingApi($apiKey, $textareaData, $actionType)
    {
        $arrayRE = '|\s|';
        $urlArray = preg_split($arrayRE, $textareaData);
        $urls = array_filter($urlArray);

        $this->client->setAuthConfig(Storage::path('keys/'.$apiKey.'.json'));
        $this->client->addScope('https://www.googleapis.com/auth/indexing');
        $httpClient = $this->client->authorize();
        $endpoint = 'https://indexing.googleapis.com/v3/urlNotifications:publish';
        foreach ($urls as $url) {
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                $result[] =  $url.'URL не является корректным.';
                continue;
            } elseif ($actionType == 'get') {
                $response = $httpClient->get('https://indexing.googleapis.com/v3/urlNotifications/metadata?url=' . urlencode($url));
            } else {
                $content = json_encode([
        'url' => $url,
        'type' => $actionType
      ]);
                $response = $httpClient->post($endpoint, ['body' => $content]);
                //   $mc->set($apiKey,$mc->get($apiKey)+1,86400);
            }
            $data = (string) $response->getBody();
            $result[] = json_decode($data, true);
        }

        return $result;
    }
}
