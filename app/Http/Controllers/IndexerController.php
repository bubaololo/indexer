<?php

namespace App\Http\Controllers;
use App\Jobs\ProcessApiRequest;
use App\Services\ApiKeysService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;


class IndexerController extends Controller
{

    public function index() {
        $keyList = ApiKeysService::getKeyList();
        return view('services/indexer/indexer', ['keys' => $keyList, 'userId' => auth()->user()->id]);
    }


    public function sendApiRequest( Request $request) {

        
        $textareaData = $request->one;
        $apiKey = $request->key;
        $action = $request->action;
        $urlArray = preg_split('|\s|', $textareaData);  // split teaxtarea content to a separate strings
        $urls = array_filter($urlArray);
        
        $urlJobs = [];
        foreach($urls as $url) {
            $urlJobs[] = new ProcessApiRequest($apiKey,$url,$action);
        }

        $batch = Bus::batch($urlJobs)->dispatch();

        return $batch->id;
  


    }

    public function getProgressStatus(Request $request) {
        $batch = Bus::findBatch($request->getContent());
        $stats = [];
        $stats['totalJobs'] = $batch->totalJobs;
        $stats['processedJobs'] = $batch->processedJobs();
        $stats['progress'] = $batch->progress();
        return json_encode($stats);
    }
}
