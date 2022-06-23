<?php

namespace App\Services;
use Google_Client;
use Illuminate\Support\Facades\Storage;

class Google {
    protected $random;
    private $client;
    public function __construct(Google_Client $client)
    {
        $this->client = $client;
    }

    public function showMeString() {
        return $this->random;
    }

    public function indexingApi ($apiKey, $textareaData, $actionType) {

        $arrayRE = '|\s|';
$urlArray = preg_split($arrayRE,$textareaData);
$urls = array_filter($urlArray);

$this->client->setAuthConfig(Storage::path('keys/'.$apiKey.'.json'));
$this->client->addScope('https://www.googleapis.com/auth/indexing');
$httpClient = $this->client->authorize();
$endpoint = 'https://indexing.googleapis.com/v3/urlNotifications:publish';
foreach($urls as $url) {
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        $result[] =  $url.'URL не является корректным.';
        continue;
      } else if ($actionType == 'get') {
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
$result[] = json_decode($data,true);
}

return $result;

    }
    
}