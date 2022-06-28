<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class ApiKeysService
{
    private $keyStatus = [];


    public static function getKeyList()
    {
        $keysFiles = Storage::files('/keys/');
        $keyList = [];
        foreach ($keysFiles as $key) {
            preg_match('/(?<=\/).*?(?=\.)/', $key, $keyN); //очищаем название ключа от '.json'
            $keyName = $keyN[0];
            $keyContent = json_decode(Storage::get($key), true);
            $keyAcc = $keyContent['client_email'];
           


            $keyList[$keyName] = $keyAcc;
        }
        return $keyList;
    }

    public static function getKeyLimits()
    {
        foreach (self::getKeyList() as $key => $value) {
            if (Cache::has($key)) {
                $keyStatus[$key] = Cache::get($key);
            } else {
                $keyStatus[$key] = 0;
            }
        }
        return json_encode($keyStatus, JSON_UNESCAPED_UNICODE);
    }

    public static function getKeyAccs()
    {
        foreach (Storage::files('/keys/') as $key) {
            $keyContent = json_decode(Storage::get($key), true);
            print_r($keyContent['client_email']);
        }
    }
    public function getSpecificKey($keyName)
    {
        $keyFilePath = '/keys/'.$keyName.'.json';
        $keyContent = json_decode(Storage::get($keyFilePath), true);
        $keyChangeDate = date('Y-m-d', Storage::lastModified($keyFilePath));
        return view('services/indexer/key', ['keyName' => $keyName, 'keyContent' => $keyContent , 'keyDate' => $keyChangeDate]);
    }

    public function deleteKey($keyName)
    {
        $keyFilePath = '/keys/'.$keyName.'.json';
     
        Storage::delete($keyFilePath);

        return redirect()->route('indexer')->with('success', "Ключ $keyName был удалён");
    }
    public function addKey(Request $request)
    {
        $validated = $request->validate([
        'file' => ['required', 'file', 'mimes:json'],
    ]);

        $origFileName = $request->file()['file']->getClientOriginalName();
        $request->file()['file']->storeAs('keys', $origFileName);
        return redirect()->route('indexer')->with('success', "Ключ $origFileName был добавлен");
    }

    public function post_upload()
    {
        $input = Input::all();
        $rules = array(
          'file' => 'image|max:3000',
      );
  
        $validation = Validator::make($input, $rules);
  
        if ($validation->fails()) {
            return Response::make($validation->errors->first(), 400);
        }
  
        $file = Input::file('file');
  
        $extension = File::extension($file['name']);
        $directory = path('public').'uploads/'.sha1(time());
        $filename = sha1(time().time()).".{$extension}";
  
        $upload_success = Input::upload('file', $directory, $filename);
  
        if ($upload_success) {
            return Response::json('success', 200);
        } else {
            return Response::json('error', 400);
        }
    }
}
