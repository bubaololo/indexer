<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


use Google_Client;
use Illuminate\Support\Facades\Storage;

class GoogleApiRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

  
    private $apiKey;
    private $url;
    private $actionType;
    private $apiKeyPath;

    public function __construct($apiKey, $url, $actionType)
    {
       
        $this->apiKey = $apiKey;
        $this->url = $url;
        $this->actionType = $actionType;
        $this->apiKeyPath = Storage::path('keys/'.$apiKey.'.json');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Google_Client;
        $client->setAuthConfig($this->apiKeyPath);
        $client->addScope('https://www.googleapis.com/auth/indexing');
        $httpClient = $client->authorize();
        $endpoint = 'https://indexing.googleapis.com/v3/urlNotifications:publish';
        
            if (!filter_var($this->url, FILTER_VALIDATE_URL)) {
              return $result[] =  $this->url.'URL не является корректным.';
                
            } elseif ($this->actionType == 'get') {
                $response = $httpClient->get('https://indexing.googleapis.com/v3/urlNotifications/metadata?url=' . urlencode($this->url));
            } else {
                $content = json_encode([
        'url' => $this->url,
        'type' => $this->actionType
      ]);
                $response = $httpClient->post($endpoint, ['body' => $content]);

                cache([$this->apiKey => cache($this->apiKey)+1,86400]);
            }
            $data = (string) $response->getBody();
            $result[] = json_decode($data, true);
        

        return $result;
    }
    }

