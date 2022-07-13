<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Bus\Batchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\GoogleApiService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redis;

class ProcessApiRequest implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

  
    private $apiKey;
    private $url;
    private $actionType;
    private $apiKeyPath;
    public $userId;
    private $api;

    public function __construct($apiKey, $url, $actionType)
    {
        $this->apiKey = $apiKey;
        $this->url = $url;
        $this->actionType = $actionType;
        $this->apiKeyPath = Storage::path('keys/'.$apiKey.'.json');
        $this->userId = auth()->user()->id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(GoogleApiService $api)
    {
        $this->api = $api;
        Redis::throttle('key')->block(9000)->allow(599)->every(60)->then(function () {

            $this->api->sendRequest($this->apiKey, $this->url, $this->actionType, $this->userId);
            
        });
        }
    // public function handle(GoogleApiService $api)
    // {
    //     $api->sendRequest($this->apiKey, $this->url, $this->actionType, $this->userId);
    // }
}