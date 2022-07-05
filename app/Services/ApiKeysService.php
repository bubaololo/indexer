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

}
