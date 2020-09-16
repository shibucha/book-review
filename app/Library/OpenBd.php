<?php

namespace app\Library;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class OpenBd
{
    public static function openBdIsbn($isbn)
    {

        $isbn =  urlencode($isbn);
        
        $url = 'https://api.openbd.jp/v1/get?isbn='. $isbn .'&pretty';

        $client = new Client();

        $response = $client->request("GET", $url);

        $body = $response->getBody();

        $bodyArray = json_decode($body, true);

        return $bodyArray['summary'];
    }

    public static function OpenBdStore(){
        
    }
}
