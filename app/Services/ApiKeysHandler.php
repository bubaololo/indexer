<?php
namespace App\Services;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;


class ApiKeysHandler {

   
   private $keyStatus = [];

public static function getKeyNames() {
    // Cache::put('key', 'value');
    // echo Cache::get('key');
    $keysFiles = Storage::files('/keys/');
    $keyNames = [];
foreach($keysFiles as $key) {
    preg_match('/(?<=\/).*?(?=\.)/', $key, $key); //очищаем название ключа от '.json'
    $keyName = $key[0];
    $keyNames[] = $keyName;
    // if($mc->get($key)) {
    //   $keyStatus[$key] = $mc->get($key);
    // } else {
    //   $keyStatus[$key] = 0;
    // }
  }
//   echo json_encode($keyStatus, JSON_UNESCAPED_UNICODE);
return $keyNames;
}
   
}