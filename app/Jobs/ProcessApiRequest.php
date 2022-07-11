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
        $api->sendRequest($this->apiKey, $this->url, $this->actionType, $this->userId);
    }
}