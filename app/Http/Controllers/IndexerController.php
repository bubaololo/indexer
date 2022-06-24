<?php

namespace App\Http\Controllers;
use App\Services\GoogleApiService;
use App\Services\ApiKeysService;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Request;

class IndexerController extends Controller
{

    public function index() {
        $keyNamesList = ApiKeysService::getKeyNames();
        return view('services/indexer', ['keys' => $keyNamesList]);
    }


    public function sendApiRequest( Request $request, GoogleApiService $google) {

        
        $textareaData = $request->one;
        $apiKey = $request->key;
        $action = $request->action;

        // return dd($request);
        // return json_encode($google->showMeString());
        return json_encode($google->indexingApi($apiKey, $textareaData, $action));
        // return json_encode('azaza','ebobo');


    }
}
// INVALID_ARGUMENT