<?php

namespace App\Http\Controllers;
use App\Jobs\ProcessApiRequest;
use App\Services\ApiKeysService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Events\UrlProcessed;

class IndexerController extends Controller
{

    public function index() {
        $keyList = ApiKeysService::getKeyList();
        return view('services/indexer/indexer', ['keys' => $keyList]);
    }


    public function sendApiRequest( Request $request) {

        
        $textareaData = $request->one;
        $apiKey = $request->key;
        $action = $request->action;
        // split teaxtarea content to a separate strings
        $urlArray = preg_split('|\s|', $textareaData);
        $urls = array_filter($urlArray);
        
        foreach($urls as $url) {
            ProcessApiRequest::dispatch($apiKey,$url,$action);
        }
        // return json_encode($google->indexingApi($apiKey, $textareaData, $action));
        // UrlProcessed::dispatch('yo');
        return json_encode('request processed');
  


    }
}
// INVALID_ARGUMENT