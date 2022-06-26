<?php

namespace App\Http\Controllers;
use App\Services\GoogleApiService;
use App\Services\ApiKeysService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
// use Illuminate\Support\Facades\Request;

class IndexerController extends Controller
{

    public function index() {
        $keyList = ApiKeysService::getKeyList();
        return view('services/indexer/indexer', ['keys' => $keyList]);
    }


    public function sendApiRequest( Request $request, GoogleApiService $google) {

        
        $textareaData = $request->one;
        $apiKey = $request->key;
        $action = $request->action;
        return json_encode($google->indexingApi($apiKey, $textareaData, $action));
  


    }
}
// INVALID_ARGUMENT