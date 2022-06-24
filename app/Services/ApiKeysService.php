<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class ApiKeysService
{
    private $keyStatus = [];

    public static function getKeyNames()
    {
        $keysFiles = Storage::files('/keys/');
        $keyNames = [];
        foreach ($keysFiles as $key) {
            preg_match('/(?<=\/).*?(?=\.)/', $key, $key); //очищаем название ключа от '.json'
            $keyName = $key[0];
            $keyNames[] = $keyName;
        }
        return $keyNames;
    }

    public static function getKeyLimits() {
      foreach(self::getKeyNames() as $key) {
        if(Cache::has($key)) {
          $keyStatus[$key] = Cache::get($key);
        } else {
          $keyStatus[$key] = 0;
        }
      }
      return json_encode($keyStatus, JSON_UNESCAPED_UNICODE);
    }

}
